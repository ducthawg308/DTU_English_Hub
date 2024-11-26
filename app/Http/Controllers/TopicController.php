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

    public function check(Request $request, $id){
        $exercise = \App\Models\ListeningExercise::findOrFail($id);
        
        $answer_user = $request->input('answer');
        $answer_text = $exercise->answer_text;

        $correctWords = explode(' ', $answer_text);
        $userWords = explode(' ', $answer_user);

        $result = [];
        foreach ($correctWords as $index => $word) {
            if (isset($userWords[$index]) && $userWords[$index] === $word) {
                $result[] = "<span style='color: green;'>{$word}</span>";
            } else {
                $result[] = "<span style='color: red;'>{$word}</span>";
            }
        }

        return view('exercises.listening', [
            'exercise' => $exercise,
            'result' => implode(' ', $result),
            'answer_user' => $answer_user,
        ]);
    }
}
