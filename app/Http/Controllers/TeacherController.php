<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function show(){
        return view('teacher.index');
    }

    public function showWriting(){
        return view('teacher.writing.index');
    }

    public function showSpeaking(){
        return view('teacher.speaking.index');
    }
}
