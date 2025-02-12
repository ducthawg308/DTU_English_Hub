<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamAnswers;
use App\Models\ExamQuestion;
use App\Models\ResultExam;

class ExamController extends Controller
{
    public function list(){
        $exams = Exam::with('level')->get();
        return view('exam.list',compact('exams'));
    }

    function detail($id){
        $exam = Exam::find($id);
        $questions = ExamQuestion::where('exam_id', $id)->get();
        return view('exam.detail',compact('questions', 'exam'));
    }

    public function submitTest($id, Request $request) {
        $exam = Exam::with('examQuestions')->findOrFail($id);
        $total_questions = $exam->total_questions;
        $total_correct = 0;
    
        $examResult = ResultExam::create([
            'user_id' => auth()->id(),
            'exam_id' => $exam->id,
            'score' => 0,
            'total_correct' => 0,
        ]);
    
        foreach ($exam->examQuestions as $question) {
            $selectedAnswer = $request->input("answers.{$question->id}", null);
            $isCorrect = ($selectedAnswer == $question->correct_answer) ? 1 : 0;
            $total_correct += $isCorrect;
    
            ExamAnswers::create([
                'result_exam_id' => $examResult->id,
                'exam_question_id' => $question->id,
                'selected_answer' => $selectedAnswer,
                'is_correct' => $isCorrect,
            ]);
        }

        $score = round((10 / $total_questions) * $total_correct, 2);
        $examResult->update([
            'total_correct' => $total_correct,
            'score' => $score,
        ]);
    
        return redirect()->route('exam.result', $examResult->id);
    }    

    public function showResult($id) {
        $result = ResultExam::with('answers.question')->findOrFail($id);
        return view('exam.result', compact('result'));
    }
    
}
