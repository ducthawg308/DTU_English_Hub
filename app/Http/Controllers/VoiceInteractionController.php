<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::error('Missing Gemini API Key');
            return response()->json(['error' => 'Cấu hình API chưa được thiết lập đúng'], 500);
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
            $prompt .= "  \"vocabularies\": [\n";
            $prompt .= "    {\n";
            $prompt .= "      \"word\": \"example\",\n";
            $prompt .= "      \"pronounce\": \"/ɪɡˈzæmpəl/\",\n";
            $prompt .= "      \"meaning\": \"ví dụ\",\n";
            $prompt .= "      \"example\": \"This is an example of correct pronunciation.\"\n";
            $prompt .= "    }\n";
            $prompt .= "  ],\n";
        }

        $prompt .= "\n  \"speech_text\": \"[Phiên bản tối ưu để đọc thành giọng nói, không có ký hiệu đặc biệt]";
        $prompt .= "\n}\n```<br><br>";

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
            return response()->json(['error' => 'Không thể kết nối với dịch vụ AI'], 500);
        }

        $result = $response['data'];
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Sử dụng regex để trích xuất JSON chính xác hơn
        if (!preg_match('/\{(?:[^{}]|(?R))*\}/s', $responseText, $matches)) {
            Log::error('Failed to extract JSON from response', ['raw_response' => $responseText]);
            return response()->json(['error' => 'Không thể xử lý phản hồi từ AI'], 500);
        }

        $jsonData = $matches[0];
        $parsedData = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($parsedData['response'])) {
            Log::error('Invalid JSON data', [
                'json_error' => json_last_error_msg(),
                'extracted_json' => $jsonData
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
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY');

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_TIMEOUT => 30, // Thêm timeout 30 giây
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
            return [
                'success' => false, 
                'error' => [
                    'message' => 'Lỗi khi gọi API Gemini', 
                    'http_code' => $httpCode, 
                    'curl_error' => $curlError,
                    'response' => $response
                ]
            ];
        }

        return ['success' => true, 'data' => json_decode($response, true)];
    }

    private function generateAndSaveAudio($text)
    {
        try {
            // Giới hạn độ dài văn bản cho API TTS
            $text = mb_substr($text, 0, 2000);
            
            $apiKey = env("MINIMAX_API_KEY");
            if (!$apiKey) {
                Log::error('Missing Minimax API Key');
                return null;
            }
            
            $url = "https://api.minimax.chat/v1/text_to_speech";

            $data = [
                "text" => $text,
                "voice_id" => "female-qn-qingse",
                "model_name" => "speech-01",
                "speed" => 1.0
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer $apiKey"
                ],
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_TIMEOUT => 30,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($httpCode !== 200) {
                Log::error('TTS API Error', [
                    'http_code' => $httpCode, 
                    'error' => $curlError,
                    'response' => $response
                ]);
                return null;
            }

            $result = json_decode($response, true);

            if (empty($result['audio_content'])) {
                Log::error('Empty audio content from TTS API');
                return null;
            }

            $audioContent = base64_decode($result['audio_content']);
            if (empty($audioContent)) {
                Log::error('Failed to decode base64 audio content');
                return null;
            }

            $audioId = Str::uuid()->toString();
            $audioPath = "tts_audio/{$audioId}.mp3";

            Storage::disk('public')->makeDirectory('tts_audio');

            if (Storage::disk('public')->put($audioPath, $audioContent)) {
                // Thêm thông tin audio vào database để theo dõi và dọn dẹp sau này
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
            "đọc", "tiếng anh", "english", "định nghĩa",
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