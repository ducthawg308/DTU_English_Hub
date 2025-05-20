<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\ExamSection;
use App\Models\Question;
use App\Models\ReadingPassage;
use App\Models\ListeningAudio;
use App\Models\WritingPrompt;
use App\Models\SpeakingPrompt;
use App\Models\UserExamSubmission;
use App\Models\UserWrittenResponse;
use App\Models\UserSpeakingResponse;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    public function list() 
    {
        $exams = Exam::all();
        return view('exam.list', compact('exams'));
    }

    public function room($exam_id)
    {
        $user = Auth::user();
        return view('exam.room', compact('exam_id', 'user'));
    }

    public function detail($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        $examSections = ExamSection::where('exam_id', $exam_id)
            ->orderBy('id')
            ->get();
            
        $data = [
            'exam' => $exam,
            'examSections' => $examSections
        ];
        
        foreach ($examSections as $section) {
            switch ($section->skill) {
                case 'listening':
                    $listeningAudios = ListeningAudio::where('exam_section_id', $section->id)->get();
                    $listeningQuestions = Question::where('exam_section_id', $section->id)
                        ->with('choices')
                        ->get();
                    $data['listening'][$section->id] = [
                        'section' => $section,
                        'audios' => $listeningAudios,
                        'questions' => $listeningQuestions
                    ];
                    break;
                    
                case 'reading':
                    $passages = ReadingPassage::where('exam_section_id', $section->id)->get();
                    foreach ($passages as $passage) {
                        $readingQuestions = Question::where('passage_id', $passage->id)
                            ->with('choices')
                            ->get();
                        $data['reading'][$section->id][] = [
                            'passage' => $passage,
                            'questions' => $readingQuestions
                        ];
                    }
                    break;
                    
                case 'writing':
                    $writingPrompts = WritingPrompt::where('exam_section_id', $section->id)->get();
                    $data['writing'][$section->id] = [
                        'section' => $section,
                        'prompts' => $writingPrompts
                    ];
                    break;
                    
                case 'speaking':
                    $speakingPrompts = SpeakingPrompt::where('exam_section_id', $section->id)->get();
                    $data['speaking'][$section->id] = [
                        'section' => $section,
                        'prompts' => $speakingPrompts
                    ];
                    break;
            }
        }
        
        return view('exam.detail', $data);
    }

    public function evaluateWriting(Request $request){
        $apiKey = config('services.gemini.api_key');
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
    
    public function submitExam(Request $request, $exam_id)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $exam = Exam::findOrFail($exam_id);
        $examSections = ExamSection::where('exam_id', $exam_id)->get();
        $answers = $request->input('answers', []);
        $user = Auth::user();

        // Create user exam submission
        $submission = UserExamSubmission::create([
            'user_id' => $user->id,
            'exam_id' => $exam_id,
            'submitted_at' => now(),
            'listening_score' => 0,
            'reading_score' => 0,
            'writing_score' => 0,
            'speaking_score' => 0,
            'total_score' => 0,
            'status' => 'pending',
        ]);

        $results = [
            'listening' => ['score' => 0, 'total_score_possible' => 0, 'details' => []],
            'reading' => ['score' => 0, 'total_score_possible' => 0, 'details' => []],
            'writing' => [],
            'speaking' => [],
        ];

        foreach ($examSections as $section) {
            switch ($section->skill) {
                case 'listening':
                $questions = Question::where('exam_section_id', $section->id)
                    ->with('choices')
                    ->get();
                
                foreach ($questions as $question) {
                    $userAnswer = $answers[$question->id] ?? null;
                    $correctLabel = $question->correct_choice_label;
                    $score = $question->score ?? 0;
                    $results['listening']['total_score_possible'] += $score;
                    $isCorrect = $userAnswer && $correctLabel && $userAnswer === $correctLabel;
                    
                    // Calculate score directly into results array
                    if ($isCorrect) {
                        $results['listening']['score'] += $score;
                    }
                    
                    // Save answer to database
                    $userAnswerRecord = UserAnswer::create([
                        'submission_id' => $submission->id,
                        'question_id' => $question->id,
                        'selected_choice_label' => $userAnswer,
                        'is_correct' => $isCorrect,
                        'score_awarded' => $isCorrect ? $score : 0,
                    ]);
                    
                    // Populate details
                    $results['listening']['details'][] = [
                        'question_id' => $question->id,
                        'question_text' => $question->question_text,
                        'user_answer' => $userAnswer,
                        'correct_answer' => $correctLabel,
                        'score_earned' => $isCorrect ? $score : 0,
                        'is_correct' => $isCorrect,
                    ];
                }
                break;

                case 'reading':
                    $passages = ReadingPassage::where('exam_section_id', $section->id)->get();
                    foreach ($passages as $passage) {
                        $questions = Question::where('passage_id', $passage->id)
                            ->with('choices')
                            ->get();
                        foreach ($questions as $question) {
                            $userAnswer = $answers[$question->id] ?? null;
                            $correctLabel = $question->correct_choice_label;
                            $score = $question->score ?? 0;
                            $results['reading']['total_score_possible'] += $score;
                            $isCorrect = $userAnswer && $correctLabel && $userAnswer === $correctLabel;
                            if ($isCorrect) {
                                $results['reading']['score'] += $score;
                            }
                            $results['reading']['details'][] = [
                                'question_id' => $question->id,
                                'question_text' => $question->question_text,
                                'user_answer' => $userAnswer,
                                'correct_answer' => $correctLabel,
                                'score_earned' => $isCorrect ? $score : 0,
                                'is_correct' => $isCorrect,
                                'passage_title' => $passage->title,
                            ];
                        }
                    }
                    break;

                case 'writing':
                    $prompts = WritingPrompt::where('exam_section_id', $section->id)->get();
                    $writingTotalScore = 0;
                    $writingMaxScore = 0;
                    
                    foreach ($prompts as $prompt) {
                        $userAnswer = $answers['writing_' . $prompt->id] ?? '';
                        
                        // Skip empty answers
                        if (empty($userAnswer)) {
                            $results['writing'][] = [
                                'prompt_id' => $prompt->id,
                                'prompt_text' => $prompt->prompt_text,
                                'user_answer' => '',
                                'ai_score' => null,
                                'ai_feedback' => null
                            ];
                            continue;
                        }
                        
                        // Get prompt metadata for AI evaluation
                        $promptData = [
                            'level' => $prompt->level ?? 'B1',
                            'task_type' => $prompt->task_type ?? 'email',
                            'topic' => $prompt->topic ?? '',
                            'instruction' => $prompt->prompt_text ?? ''
                        ];
                        
                        // Call the AI evaluation function
                        $aiEvaluation = $this->getWritingEvaluation($userAnswer, $promptData);
                        
                        $writtenResponse = UserWrittenResponse::create([
                            'submission_id' => $submission->id,
                            'writing_prompt_id' => $prompt->id,
                            'response_text' => $userAnswer,
                            'ai_score' => $aiEvaluation ? $aiEvaluation['scores']['total'] : 0,
                            'ai_feedback' => $aiEvaluation ? json_encode($aiEvaluation) : null,
                        ]);
                        
                        // Add to total writing score
                        if ($aiEvaluation) {
                            $writingTotalScore += $aiEvaluation['scores']['total'];
                            $writingMaxScore += 10; // Assuming max score is 10 per prompt
                            
                            $results['writing'][] = [
                                'prompt_id' => $prompt->id,
                                'prompt_text' => $prompt->prompt_text,
                                'user_answer' => $userAnswer,
                                'ai_score' => $aiEvaluation['scores'],
                                'ai_feedback' => $aiEvaluation['feedback'],
                                'corrections' => $aiEvaluation['corrections']
                            ];
                        } else {
                            $results['writing'][] = [
                                'prompt_id' => $prompt->id,
                                'prompt_text' => $prompt->prompt_text,
                                'user_answer' => $userAnswer,
                                'ai_score' => null,
                                'ai_feedback' => null
                            ];
                        }
                    }
                    
                    // Store the writing score in the results
                    if ($writingMaxScore > 0) {
                        $results['writing']['score'] = $writingTotalScore;
                        $results['writing']['total_score_possible'] = $writingMaxScore;
                    }
                    break;

                case 'speaking':
                    $prompts = SpeakingPrompt::where('exam_section_id', $section->id)->get();
                    foreach ($prompts as $prompt) {
                        $userAnswer = $answers['speaking_' . $prompt->id] ?? '';
                        $audioData = null;
                        $fileName = null;
                        
                        // Check if we received base64 audio data
                        if ($userAnswer && preg_match('/^data:audio\/\w+;base64,/', $userAnswer)) {
                            // Save to storage for permanent records
                            $audioBase64 = substr($userAnswer, strpos($userAnswer, ',') + 1);
                            $decodedAudio = base64_decode($audioBase64);
                            
                            if ($decodedAudio !== false) {
                                $fileName = 'speaking_' . $exam_id . '_' . $prompt->id . '_' . Str::random(10) . '.mp3';
                                Storage::disk('public')->put('audio/speaking/' . $fileName, $decodedAudio);
                                
                                // Keep the original base64 data for direct playback in results
                                $audioData = $userAnswer;
                            }
                        }
                        
                        // Create the speaking response record
                        $speakingResponse = UserSpeakingResponse::create([
                            'submission_id' => $submission->id,
                            'speaking_prompt_id' => $prompt->id,
                            'audio_url' => $fileName,
                            'transcript' => null,
                            'ai_score' => 0,
                            'ai_feedback' => null,
                        ]);
                        
                        // Pass the data to results
                        $results['speaking'][] = [
                            'prompt_id' => $prompt->id,
                            'prompt_text' => $prompt->prompt_text,
                            'user_answer' => $audioData ? 'Audio submitted' : 'No audio submitted',
                            'audio_data' => $audioData,
                        ];
                    }
                    break;
            }
        }

        foreach ($examSections as $section) {
            switch ($section->skill) {
                case 'listening':
                    $questions = Question::where('exam_section_id', $section->id)
                        ->with('choices')
                        ->get();
                    // ... (Phần xử lý câu hỏi listening)
                    break;

                case 'reading':
                    $passages = ReadingPassage::where('exam_section_id', $section->id)->get();
                    // ... (Phần xử lý câu hỏi reading)
                    break;

                // ... (Giữ nguyên phần xử lý writing và speaking)
            }
        }

        // Update total score
        $totalScore = $results['listening']['score'] + $results['reading']['score'];
        $writingScore = $results['writing']['score'] ?? 0;

        $submission->update([
            'listening_score' => $results['listening']['score'],
            'reading_score' => $results['reading']['score'],
            'writing_score' => $writingScore,
            'total_score' => $totalScore + $writingScore,
        ]);

        // Store results in session
        $request->session()->put('exam_results', $results);

        return redirect()->route('exam.result', ['exam_id' => $exam_id]);
    }

    private function getWritingEvaluation($userWriting, $promptData)
    {
        try {
            $request = new Request();
            $request->merge([
                'user_writing' => $userWriting,
                'prompt_data' => $promptData
            ]);
            
            $response = $this->evaluateWriting($request);
            
            // If response is already a JSON object
            if ($response instanceof \Illuminate\Http\JsonResponse) {
                return $response->getData(true);
            }
            
            return null;
        } catch (\Exception $e) {
            // Log error but continue with exam submission
            Log::error('Writing evaluation failed: ' . $e->getMessage());
            return null;
        }
    }

    public function results(Request $request, $exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        $results = $request->session()->get('exam_results', []);

        return view('exam.result', compact('exam', 'results'));
    }
}
