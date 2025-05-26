<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PronounceController extends Controller
{
    public function index()
    {
        return view('pronounce.index');
    }

    public function ai()
    {
        return view('pronounce.ai');
    }

    public function ipa()
    {
        return view('pronounce.ipa');
    }

    public function generatePrompt(Request $request)
    {
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        $topic = $request->input('topic', ''); // Optional topic 
        $level = $request->input('level', 'B1'); // A1, A2, B1, B2, C1, C2
        $taskType = $request->input('task_type', 'Social Interaction'); // Social Interaction, Solution Discussion, Topic Development

        // Create prompt based on task type and level
        $prompt = "
        Hãy tạo một đề bài luyện nói tiếng Anh" . ($topic ? " về chủ đề '$topic'" : " với chủ đề ngẫu nhiên phù hợp") . ", phù hợp với trình độ $level của VSTEP.
        Loại bài: " . ($taskType === 'Social Interaction' ? "Tương tác xã hội" : ($taskType === 'Solution Discussion' ? "Thảo luận giải pháp" : "Phát triển chủ đề")) . "
        
        Trả về JSON với cấu trúc sau:

        ```json
        {
            \"prompt\": {
                \"title\": \"Tiêu đề đề bài\",
                \"instruction\": \"Hướng dẫn chi tiết cho đề bài, bao gồm thời gian chuẩn bị và thời gian nói\",
                \"level\": \"$level\",
                \"task_type\": \"$taskType\",
                \"topic\": \"Chủ đề cụ thể đã sử dụng\",
                \"preparation_time\": 30,
                \"speaking_time\": 120,
                \"notes\": \"Lưu ý cho thí sinh (ví dụ: cấu trúc bài nói, từ vựng gợi ý)\"
            },
            \"sample\": {
                \"content\": \"Đây là bài nói mẫu bằng văn bản, được định dạng HTML với các thẻ <p> cho mỗi đoạn.\",
                \"word_count\": 100
            }
        }
        ```

        **Yêu cầu quan trọng**:
        - Chỉ trả về JSON, không giải thích.
        - Bài mẫu phải có định dạng HTML với các thẻ <p> cho mỗi đoạn.
        - Word count cho bài mẫu phải phù hợp với trình độ:
           - A1-A2: 50-80 từ
           - B1-B2: 100-150 từ
           - C1-C2: 180-250 từ
        - Nội dung phải phù hợp với trình độ yêu cầu:
           - A1: Từ ngữ và cấu trúc rất đơn giản, câu ngắn.
           - A2: Từ ngữ cơ bản, cấu trúc đơn giản.
           - B1: Từ ngữ thông dụng, cấu trúc trung bình.
           - B2: Từ ngữ phong phú, cấu trúc đa dạng.
           - C1: Từ ngữ học thuật, cấu trúc phức tạp.
           - C2: Từ ngữ chuyên sâu, cấu trúc rất phức tạp.
        - Thời gian chuẩn bị và nói:
           - A1-A2: Chuẩn bị 15-30 giây, nói 60-90 giây.
           - B1-B2: Chuẩn bị 30-60 giây, nói 120-180 giây.
           - C1-C2: Chuẩn bị 60-90 giây, nói 180-300 giây.
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

        // Extract JSON from AI response
        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return response()->json(["error" => "Phản hồi không hợp lệ từ AI"], 500);
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        if (!isset($parsedData['prompt']) || !isset($parsedData['sample'])) {
            return response()->json(["error" => "Không tìm thấy dữ liệu đề bài hoặc bài mẫu"], 500);
        }

        return response()->json($parsedData);
    }

    public function evaluateSpeaking(Request $request)
    {
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        
        $userSpeakingText = $request->input('user_speaking_text'); // Transcribed text from audio
        $promptData = $request->input('prompt_data');
        $level = $promptData['level'] ?? 'B1';
        $taskType = $promptData['task_type'] ?? 'monologue';
        $topic = $promptData['topic'] ?? '';
        $instruction = $promptData['instruction'] ?? '';

        if (empty($userSpeakingText)) {
            return response()->json(['error' => 'User speaking text is required'], 400);
        }

        $prompt = "
        Evaluate the following transcribed English speaking response by a learner based on the criteria suitable for the $level level of VSTEP. Be objective, precise, and fair, ensuring the scores reflect the actual quality of the response. Avoid defaulting to average scores (e.g., 7–8) unless the response genuinely warrants them. Use the full 0–10 range for each criterion based on the response's merits.

        **Task Instruction**: $instruction
        
        **Learner's Transcribed Response**:
        \"\"\"
        $userSpeakingText
        \"\"\"
        
        **Evaluation Criteria** (tailored to $level and $taskType):
        - **Pronunciation (0–10)**: How clear and accurate is the pronunciation? Consider intelligibility and accuracy for $level:
          - A1/A2: Basic intelligibility, frequent errors acceptable.
          - B1/B2: Generally clear, occasional errors.
          - C1/C2: Near-native clarity, minimal errors.
        - **Fluency (0–10)**: How smooth and natural is the speech flow? Consider hesitations and pacing for $level:
          - A1/A2: Frequent pauses, slow delivery acceptable.
          - B1/B2: Moderate fluency, some hesitations.
          - C1/C2: Smooth delivery, minimal hesitations.
        - **Vocabulary (0–10)**: How appropriate and varied is the vocabulary for $level? Consider word choice and range:
          - A1/A2: Basic, repetitive vocabulary.
          - B1/B2: Adequate range, some precise terms.
          - C1/C2: Sophisticated, precise vocabulary.
        - **Grammar (0–10)**: How accurate is the grammar? Consider complexity and error frequency for $level:
          - A1/A2: Basic structures, frequent minor errors acceptable.
          - B1/B2: Varied structures, occasional errors.
          - C1/C2: Complex structures, minimal errors.

        **Output Format**:
        Return a JSON object with the following structure:

        ```json
        {
            \"scores\": {
                \"pronunciation\": 0.0,
                \"fluency\": 0.0,
                \"vocabulary\": 0.0,
                \"grammar\": 0.0,
                \"total\": 0.0
            },
            \"feedback\": {
                \"general\": \"Nhận xét chung về chất lượng bài nói bằng tiếng Việt.\",
                \"strengths\": [\"Điểm mạnh 1 bằng tiếng Việt\", \"Điểm mạnh 2 bằng tiếng Việt\"],
                \"weaknesses\": [\"Điểm yếu 1 bằng tiếng Việt\", \"Điểm yếu 2 bằng tiếng Việt\"],
                \"suggestions\": \"Gợi ý cải thiện cụ thể bằng tiếng Việt.\"
            },
            \"corrections\": {
                \"corrected_text\": \"Bài nói đầy đủ (dựa trên văn bản đã chuyển đổi) với các lỗi được đánh dấu và sửa chữa bằng HTML/CSS. Sử dụng <span class='error' style='color: red; text-decoration: line-through;'>[nguyên gốc]</span> cho phần lỗi và <span class='correction' style='color: green; font-weight: bold;' title='Lỗi: [nguyên gốc] -> [đã sửa]'>[đã sửa]</span> cho phần sửa chữa. Giữ nguyên các phần không có lỗi.\",
                \"detailed_errors\": [
                    {
                        \"error\": \"Mô tả lỗi bằng tiếng Việt\",
                        \"correction\": \"Phiên bản đã sửa bằng tiếng Việt\",
                        \"explanation\": \"Giải thích lý do lỗi và cách sửa bằng tiếng Việt\"
                    }
                ]
            }
        }
        ```

        **Important Requirements**:
        - Return only the JSON object, no additional explanations.
        - Scores must be between 0 and 10, rounded to one decimal place (e.g., 8.5).
        - The total score must be the arithmetic mean of the four criteria (pronunciation, fluency, vocabulary, grammar), rounded to one decimal place.
        - All text in the `feedback` and `corrections` sections (including general, strengths, weaknesses, suggestions, error descriptions, corrections, and explanations) must be in Vietnamese, specific, constructive, and tailored to the response's quality and $level.
        - In `corrected_text`, include the full transcribed text. Mark errors with <span class='error' style='color: red; text-decoration: line-through;'>[original]</span> to show the incorrect text, and immediately follow with <span class='correction' style='color: green; font-weight: bold;' title='Lỗi: [original] -> [corrected]'>[corrected]</span> for the corrected version. Preserve all correct parts without modification.
        - Evaluate strictly based on the $level and $taskType criteria, rewarding excellence and penalizing deficiencies appropriately.
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

        // Extract JSON from AI response
        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return response()->json(["error" => "Phản hồi không hợp lệ từ AI"], 500);
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        if (!isset($parsedData['scores']) || !isset($parsedData['feedback']) || !isset($parsedData['corrections'])) {
            return response()->json(["error" => "Không tìm thấy dữ liệu đánh giá"], 500);
        }

        return response()->json($parsedData);
    }
}