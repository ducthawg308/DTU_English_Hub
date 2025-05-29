<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\PurchasedExercise;
use App\Models\Audios;
use App\Models\ListeningExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExercisesController extends Controller
{
    public function index(){
        return view('exercises.index');
    }

    public function ai(){
        return view('exercises.ai');
    }

    public function list(){
        $topics = Topic::with('level')->withCount('listeningExercises')->get();
        return view('exercises.topic', compact('topics'));
    }

    function show($id) {
        $topic = Topic::with('listeningExercises','level')->withCount('listeningExercises')->findOrFail($id);
        $purchasedTopics = PurchasedExercise::where('user_id', Auth::id())->pluck('topic_id')->toArray();
        $isFree = $topic->price == 0;
        $isPurchased = $isFree || PurchasedExercise::where('user_id', Auth::id())->where('topic_id', $id)->exists();
        return view('exercises.topic-detail', compact('topic', 'isPurchased', 'purchasedTopics'));
    }

    public function listening($topicId, $id) {
        $topic = Topic::findOrFail($topicId);
        $exercise = ListeningExercise::findOrFail($id);
        $audios = Audios::where('listening_id', $id)->get();
    
        return view('exercises.listening', compact('topic', 'exercise', 'audios'));
    }
    
    public function check(Request $request, $id) {
        $audio = Audios::findOrFail($id);
        
        $answer_user = strtolower(trim($request->input('answer')));
        $answer_text = strtolower(trim($audio->answer_correct));
    
        $correctWords = explode(' ', $answer_text);
        $userWords = explode(' ', $answer_user);
    
        $correct = ($answer_user === $answer_text); // Kiểm tra xem đúng hoàn toàn không
    
        $result = [];
        foreach ($correctWords as $index => $word) {
            if (isset($userWords[$index]) && $userWords[$index] === $word) {
                $result[] = "<span style='color: green;'>{$word}</span>";
            } else {
                // Thay từ sai bằng số lượng `*` tương ứng với độ dài từ gốc
                $result[] = "<span style='color: red;'>" . str_repeat('*', strlen($word)) . "</span>";
            }
        }
    
        return response()->json([
            'result' => implode(' ', $result),
            'correct' => $correct
        ]);
    }
    
    public function hint(Request $request, $id) {
        $audio = Audios::findOrFail($id);
        $answer_text = strtolower(trim($audio->answer_correct));
        $correctWords = explode(' ', $answer_text);
    
        // Lấy danh sách từ đã gợi ý từ session (nếu có)
        $hint = session("hint_$id", array_fill(0, count($correctWords), '****'));
        
        // Lấy vị trí từ tiếp theo cần hiển thị
        $hintIndex = session("hint_index_$id", 0);
    
        // Kiểm tra xem còn từ nào để gợi ý không
        if ($hintIndex < count($correctWords)) {
            $word = $correctWords[$hintIndex];
    
            if (strlen($word) <= 2) {
                $hint[$hintIndex] = $word; // Nếu từ có 1-2 ký tự, giữ nguyên
            } else {
                $hint[$hintIndex] = $word[0] . str_repeat('*', strlen($word) - 2) . $word[strlen($word) - 1];
            }
    
            // Cập nhật vị trí gợi ý tiếp theo
            session(["hint_index_$id" => $hintIndex + 1]);
            session(["hint_$id" => $hint]);
        }
    
        return response()->json(['hint' => implode(' ', $hint)]);
    }

    public function showAnswer($id) {
        $audio = Audios::findOrFail($id);
        return response()->json(['answer' => $audio->answer_correct]);
    }    

    public function generateTest(Request $request){
        try {
            // Validate required fields
            $request->validate([
                'level' => 'required|in:A2,B1,B2,C1',
                'question_count' => 'required',
                'topic' => 'required',
                'accent' => 'required',
                'test_parts' => 'required|array|min:1',
                'output_formats' => 'required|array|min:1'
            ]);

            $apiKey = config('services.gemini.api_key');
            if (!$apiKey) {
                return response()->json(['error' => 'Missing API Key'], 500);
            }

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
            
            // Lấy dữ liệu từ form
            $level = $request->input('level', 'B1');
            $questionCount = $request->input('question_count', '20');
            if ($questionCount === 'custom') {
                $questionCount = $request->input('custom_question_count', 10);
            }
            
            $topic = $request->input('topic', 'mixed');
            if ($topic === 'custom') {
                $topic = $request->input('custom_topic_text', 'Daily conversation');
            }
            
            $accent = $request->input('accent', 'mixed');
            $testParts = $request->input('test_parts', ['part1', 'part2', 'part3']);
            $outputFormats = $request->input('output_formats', ['web']);

            // Mapping topic names
            $topicMap = [
                'daily_communication' => 'Daily Communication',
                'academic' => 'Academic/School',
                'workplace' => 'Workplace/Office',
                'travel' => 'Travel',
                'mixed' => 'Mixed Topics'
            ];
            $topicName = $topicMap[$topic] ?? $topic;

            // Mapping accent names
            $accentMap = [
                'british' => 'British English',
                'american' => 'American English',
                'mixed' => 'Mixed Accents'
            ];
            $accentName = $accentMap[$accent] ?? $accent;

            $prompt = "
            Hãy tạo một bài test Listening tiếng Anh theo chuẩn VSTEP với các yêu cầu sau:
            - Trình độ: $level
            - Số câu hỏi: $questionCount
            - Chủ đề: $topicName
            - Giọng đọc: $accentName
            - Các phần: " . implode(', ', $testParts) . "
            
            Trả về JSON với cấu trúc sau:

            ```json
            {
                \"test_info\": {
                    \"title\": \"VSTEP Listening Practice Test\",
                    \"level\": \"$level\",
                    \"question_count\": $questionCount,
                    \"topic\": \"$topicName\",
                    \"accent\": \"$accentName\",
                    \"parts\": [\"Part 1\", \"Part 2\", \"Part 3\"],
                    \"duration\": 30
                },
                \"listening_exercises\": [
                    {
                        \"title\": \"Part 1 - Short Conversation\",
                        \"audio_text\": \"[Audio Script] A: Hello, how can I help you today? B: I'd like to book a table for two people...\",
                        \"audios\": [
                            {
                                \"question\": \"What does the customer want to do?\",
                                \"answer_correct\": \"book a table\",
                                \"hint\": \"The customer wants to _____ a _____\"
                            },
                            {
                                \"question\": \"How many people will be dining?\",
                                \"answer_correct\": \"two people\",
                                \"hint\": \"_____ people\"
                            }
                        ]
                    },
                    {
                        \"title\": \"Part 2 - Long Monologue\",
                        \"audio_text\": \"[Audio Script] Welcome to our university orientation program...\",
                        \"audios\": [
                            {
                                \"question\": \"What is the main purpose of this talk?\",
                                \"answer_correct\": \"orientation program\",
                                \"hint\": \"university _____ _____\"
                            }
                        ]
                    }
                ]
            }
            ```

            ⚠ **Yêu cầu quan trọng:**  
            - Không giải thích, chỉ trả về JSON.
            - Tạo đủ $questionCount câu hỏi fill-in-the-blank phân bố đều qua các phần.
            - Mỗi audio_text phải là script đầy đủ có thể đọc thành audio.
            - Câu trả lời answer_correct phải ngắn gọn, chính xác.
            - Hint phải hữu ích nhưng không tiết lộ hoàn toàn đáp án.
            - Nội dung phù hợp với trình độ $level:
               - A2: Từ vựng cơ bản, câu đơn giản
               - B1: Từ vựng thông dụng, câu phức tạp vừa phải
               - B2: Từ vựng phong phú, câu phức tạp
               - C1: Từ vựng học thuật, câu phức tạp cao
            - Đảm bảo chủ đề $topicName được thể hiện rõ trong nội dung.
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
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                return response()->json([
                    'error' => 'Lỗi kết nối: ' . $curlError
                ], 500);
            }

            if ($httpCode !== 200) {
                return response()->json([
                    'error' => 'Lỗi khi gọi API AI',
                    'http_code' => $httpCode,
                    'response' => json_decode($response, true)
                ], 500);
            }

            $result = json_decode($response, true);
            
            if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return response()->json(['error' => 'Phản hồi không hợp lệ từ AI'], 500);
            }

            $responseText = $result['candidates'][0]['content']['parts'][0]['text'];

            // Bóc tách JSON từ nội dung AI trả về
            $jsonStart = strpos($responseText, '{');
            $jsonEnd = strrpos($responseText, '}');
            
            if ($jsonStart === false || $jsonEnd === false) {
                return response()->json(["error" => "Không tìm thấy JSON trong phản hồi từ AI"], 500);
            }

            $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
            $parsedData = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(["error" => "JSON không hợp lệ: " . json_last_error_msg()], 500);
            }

            if (!isset($parsedData['test_info']) || !isset($parsedData['listening_exercises'])) {
                return response()->json(["error" => "Không tìm thấy dữ liệu test hoặc bài tập"], 500);
            }

            // Format response data for frontend
            $responseData = [
                'level' => $parsedData['test_info']['level'],
                'question_count' => $parsedData['test_info']['question_count'],
                'topic' => $parsedData['test_info']['topic'],
                'accent' => $parsedData['test_info']['accent'],
                'parts' => $parsedData['test_info']['parts'],
                'duration' => $parsedData['test_info']['duration'],
                'content' => $this->formatTestContent($parsedData['listening_exercises'])
            ];

            return response()->json($responseData);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Dữ liệu không hợp lệ',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    private function formatTestContent($exercises) {
        $html = '';
        foreach ($exercises as $index => $exercise) {
            $html .= "<div class='exercise-section'>";
            $html .= "<h3>{$exercise['title']}</h3>";
            $html .= "<div class='audio-script'>";
            $html .= "<strong>Audio Script:</strong><br>";
            $html .= "<p>" . nl2br(htmlspecialchars($exercise['audio_text'])) . "</p>";
            $html .= "</div>";
            
            if (isset($exercise['audios']) && is_array($exercise['audios'])) {
                $html .= "<div class='questions'>";
                foreach ($exercise['audios'] as $qIndex => $audio) {
                    $questionNum = $qIndex + 1;
                    $html .= "<div class='question-item'>";
                    $html .= "<p><strong>Question {$questionNum}:</strong> {$audio['question']}</p>";
                    $html .= "<p><strong>Answer:</strong> {$audio['answer_correct']}</p>";
                    if (isset($audio['hint'])) {
                        $html .= "<p><strong>Hint:</strong> {$audio['hint']}</p>";
                    }
                    $html .= "</div>";
                }
                $html .= "</div>";
            }
            $html .= "</div><br>";
        }
        return $html;
    }

    private function getLevelId($level) {
        $levelMap = [
            'A1' => 1,
            'A2' => 2,
            'B1' => 3,
            'B2' => 4,
            'C1' => 5,
            'C2' => 6
        ];
        return $levelMap[$level] ?? 3; // Default to B1
    }
}