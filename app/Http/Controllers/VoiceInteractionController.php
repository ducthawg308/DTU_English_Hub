<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            return response()->json(['error' => 'Missing API Key'], 500);
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
            $prompt .= "\n  \"vocabularies\": [\n    {\n      \"word\": \"example\",\n      \"pronounce\": \"/\u026a\u0261\u02c8z\xe6mp\u0259l/\",\n      \"meaning\": \"ví dụ\",\n      \"example\": \"This is an example of correct pronunciation.\"\n    }\n  ],";
        }

        $prompt .= "\n  \"speech_text\": \"[Phiên bản tối ưu để đọc thành giọng nói, không có ký hiệu đặc biệt]";
        $prompt .= "\n}\n```<br><br>";

        if ($needVocabulary) {
            $prompt .= "Hãy cung cấp 3-5 từ vựng liên quan đến câu hỏi. Mỗi từ cần có nghĩa tiếng Việt, cách phát âm, và ví dụ rõ ràng.<br><br>";
        }

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
            return response()->json($response['error'], 500);
        }

        $result = $response['data'];
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return response()->json(['error' => 'Không thể xử lý phản hồi từ AI', 'raw_response' => $responseText], 500);
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        if (!isset($parsedData['response'])) {
            return response()->json(['error' => 'Dữ liệu phản hồi không hợp lệ'], 500);
        }

        if ($needVocabulary && Auth::check()) {
            $this->logVocabularyQuestion(Auth::id(), $query, $parsedData['response']);
        }

        $speechText = $parsedData['speech_text'] ?? strip_tags($parsedData['response']);
        $audioId = $this->generateAndSaveAudio($speechText);

        if ($audioId) {
            $parsedData['audio_id'] = $audioId;
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
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
            return ['success' => false, 'error' => ['message' => 'Lỗi khi gọi API Gemini', 'http_code' => $httpCode, 'curl_error' => $curlError]];
        }

        return ['success' => true, 'data' => json_decode($response, true)];
    }

    private function generateAndSaveAudio($text)
    {
        $text = mb_substr($text, 0, 2000);

        $apiKey = env("MINIMAX_API_KEY");
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

        if ($httpCode !== 200) return null;

        $result = json_decode($response, true);

        if (empty($result['audio_content'])) return null;

        $audioContent = base64_decode($result['audio_content']);
        if (empty($audioContent)) return null;

        $audioId = Str::uuid()->toString();
        $audioPath = "tts_audio/{$audioId}.mp3";

        Storage::disk('public')->makeDirectory('tts_audio');

        try {
            Storage::disk('public')->put($audioPath, $audioContent);
            return $audioId;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function playAudio($audioId)
    {
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
        DB::table('vocabulary_question_logs')->insert([
            'user_id' => $userId,
            'query' => $query,
            'response' => $response,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}