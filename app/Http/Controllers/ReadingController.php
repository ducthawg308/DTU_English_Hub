<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function index(){
        return view('reading.index');
    }

    public function generateReading(Request $request){
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        $topic = $request->input('topic', 'Environment');
        $wordCount = $request->input('word_count', 250);
        $level = $request->input('level', 'B1');

        $prompt = "
        Hãy tạo một bài đọc tiếng Anh về chủ đề '$topic' với độ dài khoảng $wordCount từ, phù hợp với trình độ $level.
        Trả về JSON với cấu trúc sau:

        ```json
        {
            \"reading\": {
                \"title\": \"Title of the Reading Passage\",
                \"content\": \"<p>First paragraph of the reading passage...</p><p>Second paragraph...</p>\"
            },
            \"questions\": [
                {
                    \"question\": \"What is the main idea of the passage?\",
                    \"options\": [
                        \"Option A\",
                        \"Option B\",
                        \"Option C\",
                        \"Option D\"
                    ],
                    \"answer\": \"A\"
                },
                {
                    \"question\": \"According to the passage, what...?\",
                    \"options\": [
                        \"Option A\",
                        \"Option B\",
                        \"Option C\",
                        \"Option D\"
                    ],
                    \"answer\": \"C\"
                }
            ]
        }
        ```

        ⚠ **Yêu cầu quan trọng:**  
        - Không giải thích, chỉ trả về JSON.
        - Trả về 5 câu hỏi trắc nghiệm liên quan đến nội dung bài đọc.  
        - Bài đọc phải có định dạng HTML với các thẻ <p> cho mỗi đoạn.
        - Các đáp án phải được đánh dấu là A, B, C, D.
        - Đáp án đúng phải được cung cấp chính xác (A, B, C hoặc D).
        - Viết bài đọc theo đúng cấp độ yêu cầu:
           - A1: Từ ngữ và cấu trúc câu rất đơn giản
           - A2: Từ ngữ cơ bản và cấu trúc câu đơn giản
           - B1: Từ ngữ thông dụng và cấu trúc câu trung bình
           - B2: Từ ngữ khá phong phú và cấu trúc câu đa dạng
           - C1: Từ ngữ học thuật và cấu trúc câu phức tạp
           - C2: Từ ngữ chuyên sâu và cấu trúc câu rất phức tạp
        ";

        $data = [
            "contents" => [
                ["parts" => [["text" => $prompt]]]
            ]
        ];

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
            return response()->json([
                'error' => 'Lỗi khi gọi API AI',
                'http_code' => $httpCode,
                'response' => json_decode($response, true),
                'curl_error' => $curlError
            ], 500);
        }

        $result = json_decode($response, true);
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Bóc tách JSON từ nội dung AI trả về
        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return response()->json(["error" => "Phản hồi không hợp lệ từ AI"], 500);
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        if (!isset($parsedData['reading']) || !isset($parsedData['questions'])) {
            return response()->json(["error" => "Không tìm thấy dữ liệu bài đọc hoặc câu hỏi"], 500);
        }

        return response()->json($parsedData);
    }
}