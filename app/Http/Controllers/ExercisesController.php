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

    public function ai(Request $request){
        $topic = $request->query('topic');
        $level = $request->query('level');
        return view('exercises.ai',compact('topic', 'level'));
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
            
            **QUAN TRỌNG: Tạo đề thi VSTEP thực tế với câu hỏi trắc nghiệm 4 lựa chọn A, B, C, D**
            
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
                        \"part\": \"Part 1\",
                        \"title\": \"Short Conversations\",
                        \"instruction\": \"You will hear some conversations between two people. You will be asked to answer three questions about what you hear. Choose the best answer for each question.\",
                        \"conversations\": [
                            {
                                \"audio_text\": \"A: Excuse me, could you tell me where the nearest bank is? B: Sure, there's one just around the corner on Main Street. It's next to the pharmacy. A: Is it open now? B: Yes, it should be. They're open until 5 PM on weekdays.\",
                                \"questions\": [
                                    {
                                        \"question_number\": 1,
                                        \"question_text\": \"What is the man looking for?\",
                                        \"options\": {
                                            \"A\": \"A pharmacy\",
                                            \"B\": \"A bank\",
                                            \"C\": \"Main Street\",
                                            \"D\": \"A corner shop\"
                                        },
                                        \"correct_answer\": \"B\",
                                        \"explanation\": \"The man asks 'could you tell me where the nearest bank is?'\"
                                    },
                                    {
                                        \"question_number\": 2,
                                        \"question_text\": \"Where is the bank located?\",
                                        \"options\": {
                                            \"A\": \"Opposite the pharmacy\",
                                            \"B\": \"Far from Main Street\",
                                            \"C\": \"Next to the pharmacy\",
                                            \"D\": \"Behind the corner\"
                                        },
                                        \"correct_answer\": \"C\",
                                        \"explanation\": \"The woman says 'It's next to the pharmacy'\"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        \"part\": \"Part 2\",
                        \"title\": \"Long Conversations\",
                        \"instruction\": \"You will hear some longer conversations between two people. You will be asked to answer three questions about what you hear. Choose the best answer for each question.\",
                        \"conversations\": [
                            {
                                \"audio_text\": \"A: Good morning, I'd like to register for the computer course. B: Certainly. Which level are you interested in? We have beginner, intermediate, and advanced levels. A: I think intermediate would be suitable for me. I have some basic knowledge. B: Great. The intermediate course starts next Monday and runs for 6 weeks, twice a week. A: What time are the classes? B: They're from 7 to 9 PM on Mondays and Wednesdays. A: Perfect. How much does it cost? B: It's 200 dollars for the entire course, including materials.\",
                                \"questions\": [
                                    {
                                        \"question_number\": 3,
                                        \"question_text\": \"What does the man want to do?\",
                                        \"options\": {
                                            \"A\": \"Buy a computer\",
                                            \"B\": \"Register for a course\",
                                            \"C\": \"Get course materials\",
                                            \"D\": \"Meet on Monday\"
                                        },
                                        \"correct_answer\": \"B\",
                                        \"explanation\": \"The man says 'I'd like to register for the computer course'\"
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        \"part\": \"Part 3\",
                        \"title\": \"Academic Lectures\",
                        \"instruction\": \"You will hear part of a lecture. You will be asked to answer four questions about what you hear. Choose the best answer for each question.\",
                        \"conversations\": [
                            {
                                \"audio_text\": \"Today we're going to discuss renewable energy sources, particularly solar and wind power. Solar energy has become increasingly popular due to technological advances that have made solar panels more efficient and affordable. The cost of solar panels has decreased by over 80% in the past decade. Wind power is another important renewable energy source. Modern wind turbines can generate electricity even in low wind conditions. Both solar and wind power are environmentally friendly alternatives to fossil fuels and play a crucial role in reducing carbon emissions.\",
                                \"questions\": [
                                    {
                                        \"question_number\": 4,
                                        \"question_text\": \"What is the main topic of the lecture?\",
                                        \"options\": {
                                            \"A\": \"Fossil fuels\",
                                            \"B\": \"Carbon emissions\",
                                            \"C\": \"Renewable energy\",
                                            \"D\": \"Technology advances\"
                                        },
                                        \"correct_answer\": \"C\",
                                        \"explanation\": \"The lecture discusses renewable energy sources, particularly solar and wind power\"
                                    }
                                ]
                            }
                        ]
                    }
                ]
            }
            ```

            ⚠ **Yêu cầu quan trọng:**  
            - Không giải thích, chỉ trả về JSON hoàn chỉnh.
            - Tạo đủ $questionCount câu hỏi trắc nghiệm phân bố đều qua các phần.
            - Mỗi câu hỏi phải có 4 lựa chọn A, B, C, D.
            - Chỉ có 1 đáp án đúng cho mỗi câu hỏi.
            - Audio script phải thực tế, có thể đọc thành audio.
            - Câu hỏi phải logic và kiểm tra kỹ năng nghe hiểu.
            - Nội dung phù hợp với trình độ $level:
               - A2: Từ vựng cơ bản, tình huống đơn giản
               - B1: Từ vựng thông dụng, tình huống hàng ngày
               - B2: Từ vựng phong phú, tình huống phức tạp
               - C1: Từ vựng học thuật, nội dung chuyên sâu
            - Đảm bảo chủ đề $topicName được thể hiện rõ.
            - Part 1: Hội thoại ngắn (2-3 câu hỏi/đoạn)
            - Part 2: Hội thoại dài (3-4 câu hỏi/đoạn)  
            - Part 3: Bài giảng học thuật (4-5 câu hỏi/đoạn)
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
                'content' => $this->formatTestContent($parsedData['listening_exercises']),
                'raw_data' => $parsedData // For answer checking
            ];

            // Store test data in session for answer checking
            session(['current_test_data' => $parsedData]);

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
        $questionNumber = 1;
        
        foreach ($exercises as $partIndex => $part) {
            $html .= "<div class='exercise-section'>";
            $html .= "<h3>{$part['part']}: {$part['title']}</h3>";
            $html .= "<div class='instruction'>";
            $html .= "<p><strong>Instructions:</strong> {$part['instruction']}</p>";
            $html .= "</div>";
            
            if (isset($part['conversations']) && is_array($part['conversations'])) {
                foreach ($part['conversations'] as $convIndex => $conversation) {
                    $html .= "<div class='conversation-section'>";
                    
                    // Audio script (hidden by default, can be shown for practice)
                    $html .= "<div class='audio-script'>";
                    $html .= "<p>" . nl2br(htmlspecialchars($conversation['audio_text'])) . "</p>";
                    $html .= "</div>";
                    
                    // Questions
                    if (isset($conversation['questions']) && is_array($conversation['questions'])) {
                        $html .= "<div class='questions'>";
                        foreach ($conversation['questions'] as $question) {
                            $html .= "<div class='question-item' data-question='{$questionNumber}' data-correct='{$question['correct_answer']}'>";
                            $html .= "<p><strong>Question {$questionNumber}:</strong> {$question['question_text']}</p>";
                            
                            // Multiple choice options
                            foreach ($question['options'] as $optionKey => $optionValue) {
                                $html .= "<div class='radio-item'>";
                                $html .= "<input type='radio' id='q{$questionNumber}_{$optionKey}' name='question_{$questionNumber}' value='{$optionKey}'>";
                                $html .= "<label for='q{$questionNumber}_{$optionKey}'>{$optionKey}. {$optionValue}</label>";
                                $html .= "</div>";
                            }
                            
                            $html .= "</div>";
                            $questionNumber++;
                        }
                        $html .= "</div>";
                    }
                    
                    $html .= "</div><br>";
                }
            }
            $html .= "</div>";
        }
        return $html;
    }

    // New method to check multiple choice answers
    public function checkTest(Request $request) {
        try {
            $answers = $request->input('answers', []);
            $testData = session('current_test_data');
            
            if (!$testData) {
                return response()->json(['error' => 'Không tìm thấy dữ liệu bài test'], 404);
            }
            
            $results = [];
            $totalQuestions = 0;
            $correctAnswers = 0;
            $questionNumber = 1;
            
            // Extract correct answers from test data
            foreach ($testData['listening_exercises'] as $part) {
                if (isset($part['conversations'])) {
                    foreach ($part['conversations'] as $conversation) {
                        if (isset($conversation['questions'])) {
                            foreach ($conversation['questions'] as $question) {
                                $totalQuestions++;
                                $userAnswer = $answers["question_{$questionNumber}"] ?? null;
                                $correctAnswer = $question['correct_answer'];
                                $isCorrect = ($userAnswer === $correctAnswer);
                                
                                if ($isCorrect) {
                                    $correctAnswers++;
                                }
                                
                                $results[] = [
                                    'question_number' => $questionNumber,
                                    'user_answer' => $userAnswer,
                                    'correct_answer' => $correctAnswer,
                                    'is_correct' => $isCorrect,
                                    'question_text' => $question['question_text'],
                                    'explanation' => $question['explanation'] ?? '',
                                    'options' => $question['options']
                                ];
                                
                                $questionNumber++;
                            }
                        }
                    }
                }
            }
            
            $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
            
            return response()->json([
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'score' => $score,
                'results' => $results
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi chấm bài: ' . $e->getMessage()
            ], 500);
        }
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