<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\PurchasedExercise;
use App\Models\Audios;
use App\Models\ListeningExercise;
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

    public function listening($topicId, $id) {
        $topic = Topic::findOrFail($topicId);
        $exercise = ListeningExercise::findOrFail($id);
        $audios = Audios::where('listening_id', $id)->get();
    
        return view('exercises.listening', compact('topic', 'exercise', 'audios'));
    }
    

    public function check(Request $request, $id) {
        $audio = Audios::findOrFail($id);
        
        $answer_user = trim($request->input('answer'));
        $answer_text = trim($audio->answer_correct);
    
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
    
        return response()->json([
            'result' => implode(' ', $result)
        ]);
    }
}
