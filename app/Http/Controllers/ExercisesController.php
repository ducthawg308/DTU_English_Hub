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
    public function list(){
        $topics = Topic::with('level')->withCount('listeningExercises')->get();
        return view('exercises.topic', compact('topics'));
    }

    function show($id) {
        $topic = Topic::with('listeningExercises','level')->withCount('listeningExercises')->findOrFail($id);
        $purchasedTopics = PurchasedExercise::where('user_id', Auth::id())->pluck('topic_id')->toArray();
        $isFree = $topic->price == 0;
        $isPurchased = $isFree || PurchasedExercise::where('user_id', Auth::id())->where('topic_id', $id)->exists();
        return view('exercises.topic-detail', compact('topic', 'isPurchased', 'purchasedTopics'));
    }
    
    

    public function listening($topicId, $id) {
        $topic = Topic::findOrFail($topicId);
        $exercise = ListeningExercise::findOrFail($id);
        $audios = Audios::where('listening_id', $id)->get();
    
        return view('exercises.listening', compact('topic', 'exercise', 'audios'));
    }
    

    public function check(Request $request, $id) {
        $audio = Audios::findOrFail($id);
        
        // Chuẩn hóa câu trả lời và đáp án: Xóa khoảng trắng dư thừa + chuyển về chữ thường
        $answer_user = strtolower(trim($request->input('answer')));
        $answer_text = strtolower(trim($audio->answer_correct));
    
        $correctWords = explode(' ', $answer_text);
        $userWords = explode(' ', $answer_user);
    
        // Kiểm tra số lần kiểm tra trước đó từ session
        $sessionKey = 'hints_' . $id;
        $hintCount = session($sessionKey, 0); // Lấy số từ gợi ý hiện tại
        $hintCount = min($hintCount + 1, count($correctWords)); // Tăng gợi ý nhưng không vượt quá số từ
    
        $result = [];
        foreach ($correctWords as $index => $word) {
            if (isset($userWords[$index]) && $userWords[$index] === $word) {
                $result[] = "<span style='color: green;'>{$word}</span>"; // Đúng thì xanh
            } else if ($index < $hintCount) {
                $result[] = "<span style='color: blue;'>{$word}</span>"; // Gợi ý thì xanh dương
            } else {
                $result[] = "<span style='color: red;'>" . str_repeat('*', strlen($word)) . "</span>"; // Sai thì che
            }
        }
    
        // Lưu số lần gợi ý vào session
        session([$sessionKey => $hintCount]);
    
        return response()->json([
            'result' => implode(' ', $result),
            'hint_count' => $hintCount
        ]);
    }
}