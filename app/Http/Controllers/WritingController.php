<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WritingController extends Controller
{
    public function index(){
        return view("writing.index");
    }

    public function generatePrompt(Request $request){
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        $topic = $request->input('topic', ''); // Chủ đề tùy chọn, có thể trống
        $level = $request->input('level', 'B1'); // A1, A2, B1, B2, C1, C2
        $taskType = $request->input('task_type', 'email'); // email, essay

        // Tạo prompt dựa trên loại task và trình độ
        $prompt = "
        Hãy tạo một đề bài writing tiếng Anh" . ($topic ? " về chủ đề '$topic'" : " với chủ đề ngẫu nhiên phù hợp") . ", phù hợp với trình độ $level của VSTEP.
        Loại bài: " . ($taskType === 'email' ? "Email/Letter (formal/informal)" : "Essay (opinion, problem-solution, advantage/disadvantage...)") . "
        
        Trả về JSON với cấu trúc sau:

        ```json
        {
            \"prompt\": {
                \"title\": \"Tiêu đề đề bài\",
                \"instruction\": \"Hướng dẫn chi tiết cho đề bài\",
                \"level\": \"$level\",
                \"task_type\": \"" . $taskType . "\",
                \"topic\": \"Chủ đề cụ thể đã sử dụng\",
                \"suggested_word_count\": 150,
                \"time_suggested\": 20
            },
            \"sample\": {
                \"content\": \"Đây là bài mẫu với định dạng HTML. <p>Paragraph 1...</p><p>Paragraph 2...</p>\",
                \"word_count\": 150
            }
        }
        ```

        ⚠ **Yêu cầu quan trọng:**
        - Không giải thích, chỉ trả về JSON.
        - Bài mẫu phải có định dạng HTML với các thẻ <p> cho mỗi đoạn.
        - Word count cho bài mẫu phải phù hợp với trình độ:
           - A1-A2: 80-120 từ
           - B1-B2: 150-180 từ
           - C1-C2: 220-280 từ
        - Nội dung phải phù hợp với trình độ yêu cầu:
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

        if (!isset($parsedData['prompt']) || !isset($parsedData['sample'])) {
            return response()->json(["error" => "Không tìm thấy dữ liệu đề bài hoặc bài mẫu"], 500);
        }

        return response()->json($parsedData);
    }

    public function evaluateWriting(Request $request){
        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        
        $userWriting = $request->input('user_writing');
        $promptData = $request->input('prompt_data');
        $level = $promptData['level'] ?? 'B1';
        $taskType = $promptData['task_type'] ?? 'email';
        $topic = $promptData['topic'] ?? '';
        $instruction = $promptData['instruction'] ?? '';

        if (empty($userWriting)) {
            return response()->json(['error' => 'User writing is required'], 400);
        }

        $prompt = "
        Evaluate the following English writing by a learner based on the criteria suitable for the $level level. Be objective, precise, and fair, ensuring the scores reflect the actual quality of the writing. Avoid defaulting to average scores (e.g., 7–8) unless the writing genuinely warrants them. Use the full 0–10 range for each criterion based on the writing's merits.

        **Task Instruction**: $instruction
        
        **Learner's Writing**:
        \"\"\"
        $userWriting
        \"\"\"
        
        **Evaluation Criteria** (tailored to $level and $taskType):
        - **Content (0–10)**: How well does the writing address the task? Is the response relevant, complete, and well-developed for the $level level? For example:
          - A1/A2: Simple ideas, minimal detail.
          - B1/B2: Clear ideas, some supporting details.
          - C1/C2: Complex ideas, thorough development.
        - **Grammar (0–10)**: How accurate is the grammar? Consider the complexity and error frequency appropriate for $level:
          - A1/A2: Basic sentence structures, frequent minor errors acceptable.
          - B1/B2: Varied structures, occasional errors.
          - C1/C2: Complex structures, minimal errors.
        - **Vocabulary (0–10)**: How appropriate and varied is the vocabulary for $level? Consider word choice and range:
          - A1/A2: Basic, repetitive vocabulary.
          - B1/B2: Adequate range, some precise terms.
          - C1/C2: Sophisticated, precise vocabulary.
        - **Structure (0–10)**: How well-organized is the writing? Consider coherence, paragraphing, and logical flow for $taskType (e.g., email structure for emails, essay structure for essays):
          - A1/A2: Simple organization, minimal coherence.
          - B1/B2: Clear paragraphs, logical flow.
          - C1/C2: Sophisticated organization, seamless transitions.

        **Output Format**:
        Return a JSON object with the following structure:

        ```json
        {
            \"scores\": {
                \"content\": 0.0,
                \"grammar\": 0.0,
                \"vocabulary\": 0.0,
                \"structure\": 0.0,
                \"total\": 0.0
            },
            \"feedback\": {
                \"general\": \"Nhận xét chung về chất lượng bài viết bằng tiếng Việt.\",
                \"strengths\": [\"Điểm mạnh 1 bằng tiếng Việt\", \"Điểm mạnh 2 bằng tiếng Việt\"],
                \"weaknesses\": [\"Điểm yếu 1 bằng tiếng Việt\", \"Điểm yếu 2 bằng tiếng Việt\"],
                \"suggestions\": \"Gợi ý cải thiện cụ thể bằng tiếng Việt.\"
            },
            \"corrections\": {
                \"corrected_text\": \"Bài viết đầy đủ với các lỗi được đánh dấu và sửa chữa bằng HTML/CSS. Sử dụng <span class='error' style='color: red; text-decoration: line-through;'>[nguyên gốc]</span> cho phần lỗi và <span class='correction' style='color: green; font-weight: bold;' title='Lỗi: [nguyên gốc] -> [đã sửa]'>[đã sửa]</span> cho phần sửa chữa. Giữ nguyên các phần không có lỗi.\",
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
        - The total score must be the arithmetic mean of the four criteria (content, grammar, vocabulary, structure), rounded to one decimal place.
        - All text in the `feedback` and `corrections` sections (including general, strengths, weaknesses, suggestions, error descriptions, corrections, and explanations) must be in Vietnamese, specific, constructive, and tailored to the writing's quality and $level.
        - In `corrected_text`, include the full text of the writing. Mark errors with <span class='error' style='color: red; text-decoration: line-through;'>[original]</span> to show the incorrect text, and immediately follow with <span class='correction' style='color: green; font-weight: bold;' title='Lỗi: [original] -> [corrected]'>[corrected]</span> for the corrected version. Preserve all correct parts of the text without modification. Ensure the styling is clear and visually distinct for users.
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

        // Bóc tách JSON từ nội dung AI trả về
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