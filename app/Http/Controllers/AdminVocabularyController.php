<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminVocabularyController extends Controller
{
    function list(){
        return view('admin.vocabulary.list');
    }

    function add(){
        return view('admin.vocabulary.add');
    }

    function edit($id){
        return view('admin.vocabulary.edit');
    }
}
