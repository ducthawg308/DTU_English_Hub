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
use Illuminate\Http\Request;

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
        return view('exam.room', compact('exam_id','user'));
    }

    public function detail($exam_id)
    {
        // Get the exam with its related information
        $exam = Exam::findOrFail($exam_id);
        
        // Get exam sections with their related data
        $examSections = ExamSection::where('exam_id', $exam_id)
            ->orderBy('id')
            ->get();
            
        $data = [
            'exam' => $exam,
            'examSections' => $examSections
        ];
        
        // For each section, load the appropriate content based on skill type
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
        // Validate the request
        $request->validate([
            'answers' => 'required|array',
        ]);

        $exam = Exam::findOrFail($exam_id);
        $examSections = ExamSection::where('exam_id', $exam_id)->get();
        $answers = $request->input('answers', []);

        $results = [
            'listening' => ['score' => 0, 'total_score_possible' => 0, 'details' => []],
            'reading' => ['score' => 0, 'total_score_possible' => 0, 'details' => []],
            'writing' => [],
            'speaking' => [], // Included for completeness, though not scored
        ];

        // Process each section
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
                        if ($isCorrect) {
                            $results['listening']['score'] += $score;
                        }
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
                        $results['writing'][] = [
                            'prompt_id' => $prompt->id,
                            'prompt_text' => $prompt->prompt_text,
                            'user_answer' => $userAnswer,
                        ];
                    }
                    break;

                case 'speaking':
                    $prompts = SpeakingPrompt::where('exam_section_id', $section->id)->get();
                    foreach ($prompts as $prompt) {
                        $userAnswer = $answers['speaking_' . $prompt->id] ?? '';
                        $results['speaking'][] = [
                            'prompt_id' => $prompt->id,
                            'prompt_text' => $prompt->prompt_text,
                            'user_answer' => $userAnswer ? 'Audio submitted' : 'No audio submitted',
                        ];
                    }
                    break;
            }
        }

        // Store results in session to pass to results view
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