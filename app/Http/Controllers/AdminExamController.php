<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminExamController extends Controller
{
    function list(){
        $exams = Exam::with('level')->get();
        return view('admin.exam.list', compact('exams'));
    }

    function add(){
        return view('admin.exam.add');
    }

    function delete ($id){
        Exam::find($id)->delete();
        return redirect('admin/exam/list');
    }
}
