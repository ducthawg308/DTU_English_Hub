<?php

namespace App\Http\Controllers;

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
        
        // Process exam submission
        // Save user answers to database
        // Calculate scores
        
        // Redirect to results page
        return redirect()->route('exam.results', ['exam_id' => $exam_id]);
    }

    public function results(){
        
    }
}