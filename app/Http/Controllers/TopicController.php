<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    //
    function list(){
        $topics = Topic::with('level')->get();
        return view('exercises.topic',compact('topics'));
    }

    function show($id){
        $topic = Topic::with('listeningExercises')->findOrFail($id);
        return view('exercises.topic-detail', compact('topic'));
    }

    function listening($topicId, $id){
        $exercise = \App\Models\ListeningExercise::findOrFail($id);

        return view('exercises.listening', compact('exercise'));
    }
}
