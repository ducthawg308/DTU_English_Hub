<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\PurchasedExercise;
use App\Models\Audios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExercisesController extends Controller
{
    public function list()
    {
        $topics = Topic::with('level')->get();
        $purchasedTopics = PurchasedExercise::where('user_id', Auth::id())->pluck('topic_id')->toArray();
    
        return view('exercises.topic', compact('topics', 'purchasedTopics'));
    }

    function show($id){
        $topic = Topic::with('listeningExercises')->findOrFail($id);
        $isPurchased = PurchasedExercise::where('user_id', Auth::id())->where('topic_id', $id)->exists();
        return view('exercises.topic-detail', compact('topic', 'isPurchased'));
    }

    function listening($topicId, $id){
        $audios = Audios::where('listening_id', $id)->get();
        return view('exercises.listening', compact('audios'));
    }

    public function check(Request $request, $id){
        $audio = Audios::findOrFail($id);
        
        $answer_user = $request->input('answer');
        $answer_text = $audio->answer_correct; 
    
        $correctWords = explode(' ', $answer_text);
        $userWords = explode(' ', $answer_user);
    
        $result = [];
        foreach ($correctWords as $index => $word) {
            if (isset($userWords[$index]) && $userWords[$index] === $word) {
                $result[] = "<span style='color: green;'>{$word}</span>";
            } else {
                $result[] = "<span style='color: red;'>" . str_repeat('*', strlen($word)) . "</span>";
            }
        }
    
        $audios = \App\Models\Audios::where('listening_id', $audio->listening_id)->get();
    
        $results = [];
        $results[$id] = implode(' ', $result);
    
        return view('exercises.listening', compact('audios', 'results', 'id'));
    }
}
