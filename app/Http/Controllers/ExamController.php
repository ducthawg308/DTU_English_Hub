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
                    foreach ($prompts as $prompt) {
                        $userAnswer = $answers['writing_' . $prompt->id] ?? '';
                        $writtenResponse = UserWrittenResponse::create([
                            'submission_id' => $submission->id,
                            'writing_prompt_id' => $prompt->id,
                            'response_text' => $userAnswer,
                            'ai_score' => 0,
                            'ai_feedback' => null,
                        ]);
                        $results['writing'][] = [
                            'prompt_id' => $prompt->id,
                            'prompt_text' => $prompt->prompt_text,
                            'user_answer' => $writtenResponse->response_text,
                        ];
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
                            'audio_url' => $fileName, // Store just the filename in the database
                            'transcript' => null,
                            'ai_score' => 0,
                            'ai_feedback' => null,
                        ]);
                        
                        // Pass the data to results
                        $results['speaking'][] = [
                            'prompt_id' => $prompt->id,
                            'prompt_text' => $prompt->prompt_text,
                            'user_answer' => $audioData ? 'Audio submitted' : 'No audio submitted',
                            'audio_data' => $audioData, // This contains the complete base64 data string
                        ];
                    }
                    break;
            }
        }

        // Update total score
        $submission->update([
            'total_score' => $submission->listening_score + $submission->reading_score,
        ]);

        // Store results in session
        $request->session()->put('exam_results', $results);

        return redirect()->route('exam.result', ['exam_id' => $exam_id]);
    }

    public function results(Request $request, $exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        $results = $request->session()->get('exam_results', []);

        return view('exam.result', compact('exam', 'results'));
    }
}