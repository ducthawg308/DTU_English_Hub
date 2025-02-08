<?php

namespace App\Http\Controllers;

use App\Imports\ExamImport;
use App\Models\Exam;
use App\Models\Level;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminExamController extends Controller
{
    function list(){
        $exams = Exam::with('level')->get();
        return view('admin.exam.list', compact('exams'));
    }

    function add(){
        $levels = Level::all();
        return view('admin.exam.add',compact('levels'));
    }

    function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'time' => 'required|integer',
            'total_question' => 'required|integer',
            'level' => 'required|exists:levels,id',
            'file' => 'required|mimes:xlsx,csv',
        ]);
    
        $exam = Exam::create([
            'name' => $request->input('name'),
            'time' => $request->input('time'),
            'total_questions' => $request->input('total_question'),
            'level_id' => $request->input('level'),
        ]);
    
        Excel::import(new ExamImport($exam->id), $request->file('file'));
    
        return redirect('admin/exam/list')->with('status','Thêm bài test exam thành công!');
    }
    

    function delete ($id){
        Exam::find($id)->delete();
        return redirect('admin/exam/list');
    }
}
