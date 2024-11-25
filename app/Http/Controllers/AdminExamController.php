<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminExamController extends Controller
{
    //
    function list(){
        return view('admin.exam.list');
    }
}
