<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class VoiceInteractionController extends Controller
{
    public function index()
    {
        return view("assistant.voice_interaction");
    }

    public function processVoice(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json(['error' => 'Không tìm thấy nội dung đầu vào'], 400);
        }

        $apiKey = config('services.gemini.api_key'); // Changed from zaloai to gemini
        if (!$apiKey) {
            Log::error('Missing Gemini API Key');
            return response()->json(['error' => 'Cấu hình API Gemini chưa được thiết lập đúng'], 500);
        }

        $needVocabulary = $this->shouldIncludeVocabulary($query);

        $prompt = "Bạn là trợ lý học tiếng Anh. Hãy trả lời câu hỏi sau một cách ngắn gọn, rõ ràng và hữu ích bằng tiếng Việt:<br><br>";
        $prompt .= "\"$query\"<br><br>";
        $prompt .= "Nếu câu hỏi liên quan đến từ vựng, phát âm, ngữ pháp tiếng Anh hoặc các chủ đề học tiếng Anh khác, hãy giải thích như một giáo viên kinh nghiệm. PHẢI trả lời bằng tiếng Việt, ngay cả khi câu hỏi bằng tiếng Anh.<br><br>";
        $prompt .= "Trả về JSON có cấu trúc sau:<br><br>";
        $prompt .= "```json\n";
        $prompt .= "{\n";
        $prompt .= "  \"response\": \"[Phản hồi chi tiết cho câu hỏi, sử dụng HTML để định dạng như <p>, <ul>, <li>, <strong>, <em>]\",";

        if ($needVocabulary) {
            $prompt .= "\n  \"vocabularies\": [\n";
            $prompt .= "    {\n";
            $prompt .= "      \"word\": \"example\",\n";
            $prompt .= "      \"pronounce\": \"/ɪɡˈzæmpəl/\",\n";
            $prompt .= "      \"meaning\": \"ví dụ\",\n";
            $prompt .= "      \"example\": \"This is an example of correct pronunciation.\"\n";
            $prompt .= "    }\n";
            $prompt .= "  ],";
        }

        $prompt .= "\n  \"speech_text\": \"[Phiên bản tối ưu để đọc thành giọng nói, không có ký hiệu đặc biệt]\"\n";
        $prompt .= "}\n```<br><br>";

        $prompt .= "⚠ Yêu cầu quan trọng:<br>";
        $prompt .= "- Phần speech_text phải là văn bản thuần túy dễ đọc thành giọng nói.<br>";
        $prompt .= "- Không cần giải thích quá chi tiết, tập trung vào thông tin chính.<br>";
        $prompt .= "- LUÔN trả lời bằng tiếng Việt, ngay cả khi câu hỏi bằng tiếng Anh.";

        $payload = [
            "contents" => [
                ["parts" => [["text" => $prompt]]]
            ]
        ];

        $response = $this->callGeminiAPI($payload);

        if (!$response['success']) {
            Log::error('Gemini API error', $response['error']);
            return response()->json(['error' => 'Không thể kết nối với dịch vụ AI: ' . ($response['error']['message'] ?? 'Unknown error')], 500);
        }

        $result = $response['data'];
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Try to handle JSON more robustly
        try {
            // First, try to extract JSON using regex (improved pattern)
            if (preg_match('/\{(?:[^{}]|(?R))*\}/s', $responseText, $matches)) {
                $jsonData = $matches[0];
                $parsedData = json_decode($jsonData, true);
                
                if (json_last_error() !== JSON_ERROR_NONE || !isset($parsedData['response'])) {
                    throw new \Exception("Invalid JSON: " . json_last_error_msg());
                }
            } else {
                // If regex fails, try to create a fallback response
                Log::warning('Failed to extract JSON from response, creating fallback', ['raw_response' => $responseText]);
                $parsedData = [
                    'response' => '<p>' . nl2br(htmlspecialchars($responseText)) . '</p>',
                    'speech_text' => strip_tags($responseText)
                ];
            }
        } catch (\Exception $e) {
            Log::error('JSON processing error', [
                'error' => $e->getMessage(),
                'raw_response' => $responseText
            ]);
            return response()->json(['error' => 'Dữ liệu phản hồi không hợp lệ'], 500);
        }

        if ($needVocabulary && Auth::check()) {
            $this->logVocabularyQuestion(Auth::id(), $query, $parsedData['response']);
        }

        $speechText = $parsedData['speech_text'] ?? strip_tags($parsedData['response']);
        $originalLength = mb_strlen($speechText);
        $audioId = $this->generateAndSaveAudio($speechText);

        if ($audioId) {
            $parsedData['audio_id'] = $audioId;
            if ($originalLength > 2000) {
                $parsedData['audio_truncated'] = true;
                $parsedData['audio_message'] = 'Nội dung âm thanh đã được cắt ngắn do quá dài';
            }
        }

        return response()->json($parsedData);
    }

    private function callGeminiAPI($data)
    {
        $apiKey = config('services.gemini.api_key'); // Changed from zaloai to gemini
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

        try {
            $response = Http::timeout(30)
                ->withHeaders(["Content-Type" => "application/json"])
                ->post($url, $data);
            
            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            } else {
                return [
                    'success' => false, 
                    'error' => [
                        'message' => 'Lỗi khi gọi API Gemini', 
                        'http_code' => $response->status(), 
                        'response' => $response->body()
                    ]
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => [
                    'message' => 'Exception: ' . $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]
            ];
        }
    }

    private function generateAndSaveAudio($text)
    {
        try {
            $text = mb_substr($text, 0, 2000); // Giới hạn độ dài

            $apiKey = config('services.zaloai.api_key'); // Keep this as zaloai for TTS
            $apiKey = "PMjfNAwn95Zb3jHTwrmW1YSuMzvCgsl9";
            if (!$apiKey) {
                Log::error('Missing ZaloAI API Key');
                return null;
            }

            $endpoint = 'https://api.zalo.ai/v1/tts/synthesize';

            $response = Http::timeout(30)
                ->withHeaders([
                    'apikey' => $apiKey,
                ])->asForm()->post($endpoint, [
                    'input' => $text,
                    'speaker_id' => 'hn_female_xuanthu_news', // hoặc speaker khác
                ]);

            if (!$response->successful()) {
                Log::error('TTS Zalo API error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

            $audioUrl = $response->json()['data']['url'] ?? null;

            if (!$audioUrl) {
                Log::error('No audio URL returned from Zalo TTS');
                return null;
            }

            // Tải về nội dung file âm thanh
            $audioResponse = Http::timeout(30)->get($audioUrl);
            
            if (!$audioResponse->successful()) {
                Log::error('Failed to download audio from URL', [
                    'status' => $audioResponse->status()
                ]);
                return null;
            }
            
            $audioContent = $audioResponse->body();

            if (empty($audioContent)) {
                Log::error('Empty audio content downloaded from Zalo TTS');
                return null;
            }

            $audioId = Str::uuid()->toString();
            $audioPath = "tts_audio/{$audioId}.mp3";

            Storage::disk('public')->makeDirectory('tts_audio');

            if (Storage::disk('public')->put($audioPath, $audioContent)) {
                // Ghi log hoặc lưu DB nếu cần
                $this->logAudioFile($audioId);
                return $audioId;
            } else {
                Log::error('Failed to save audio file to storage');
                return null;
            }

        } catch (\Exception $e) {
            Log::error('TTS generation failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    // Rest of the methods remain unchanged
    public function playAudio($audioId)
    {
        // Kiểm tra tính hợp lệ của $audioId
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $audioId)) {
            return response()->json(['error' => 'Audio ID không hợp lệ'], 400);
        }

        $audioPath = "tts_audio/{$audioId}.mp3";

        if (!Storage::disk('public')->exists($audioPath)) {
            return response()->json(['error' => 'Audio không tồn tại'], 404);
        }

        return response(Storage::disk('public')->get($audioPath))
            ->header('Content-Type', 'audio/mpeg')
            ->header('Content-Disposition', 'inline');
    }

    private function shouldIncludeVocabulary($query)
    {
        $keywords = [
            "từ vựng", "vocabulary", "nghĩa", "meaning", "từ",
            "word", "phát âm", "pronunciation", "pronounce",
            "đọc", "english", "định nghĩa",
            "definition", "dịch", "translate", "giải thích", "explain"
        ];

        foreach ($keywords as $keyword) {
            if (stripos($query, $keyword) !== false) return true;
        }

        return false;
    }

    private function logVocabularyQuestion($userId, $query, $response)
    {
        try {
            DB::table('vocabulary_logs')->insert([
                'user_id' => $userId,
                'query' => $query,
                'response' => $response,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log vocabulary question', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function logAudioFile($audioId)
    {
        try {
            DB::table('audio_files')->insert([
                'audio_id' => $audioId,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log audio file', [
                'audio_id' => $audioId,
                'error' => $e->getMessage()
            ]);
        }
    }

    // Thêm một hàm để dọn dẹp các file audio cũ
    public function cleanupOldAudioFiles()
    {
        try {
            // Lấy danh sách các file audio cũ hơn 7 ngày
            $oldFiles = DB::table('audio_files')
                ->where('created_at', '<', Carbon::now()->subDays(7))
                ->get();

            foreach ($oldFiles as $file) {
                $audioPath = "tts_audio/{$file->audio_id}.mp3";
                
                // Xóa file từ storage
                if (Storage::disk('public')->exists($audioPath)) {
                    Storage::disk('public')->delete($audioPath);
                }
                
                // Xóa bản ghi từ database
                DB::table('audio_files')->where('audio_id', $file->audio_id)->delete();
            }
            
            Log::info('Audio cleanup completed', ['removed_files' => $oldFiles->count()]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to cleanup old audio files', ['error' => $e->getMessage()]);
            return false;
        }
    }
}