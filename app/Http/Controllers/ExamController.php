<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;

class ExamController extends Controller
{
    public function list()
    {
        $exams = Exam::with('level')->get();
        return view('exam.list',compact('exams'));
    }
}
