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
        
        $answer_user = strtolower(trim($request->input('answer')));
        $answer_text = strtolower(trim($audio->answer_correct));
    
        $correctWords = explode(' ', $answer_text);
        $userWords = explode(' ', $answer_user);
    
        $correct = ($answer_user === $answer_text); // Kiểm tra xem đúng hoàn toàn không
    
        $result = [];
        foreach ($correctWords as $index => $word) {
            if (isset($userWords[$index]) && $userWords[$index] === $word) {
                $result[] = "<span style='color: green;'>{$word}</span>";
            } else {
                // Thay từ sai bằng số lượng `*` tương ứng với độ dài từ gốc
                $result[] = "<span style='color: red;'>" . str_repeat('*', strlen($word)) . "</span>";
            }
        }
    
        return response()->json([
            'result' => implode(' ', $result),
            'correct' => $correct
        ]);
    }
    
    public function hint(Request $request, $id) {
        $audio = Audios::findOrFail($id);
        $answer_text = strtolower(trim($audio->answer_correct));
        $correctWords = explode(' ', $answer_text);
    
        // Lấy danh sách từ đã gợi ý từ session (nếu có)
        $hint = session("hint_$id", array_fill(0, count($correctWords), '****'));
        
        // Lấy vị trí từ tiếp theo cần hiển thị
        $hintIndex = session("hint_index_$id", 0);
    
        // Kiểm tra xem còn từ nào để gợi ý không
        if ($hintIndex < count($correctWords)) {
            $word = $correctWords[$hintIndex];
    
            if (strlen($word) <= 2) {
                $hint[$hintIndex] = $word; // Nếu từ có 1-2 ký tự, giữ nguyên
            } else {
                $hint[$hintIndex] = $word[0] . str_repeat('*', strlen($word) - 2) . $word[strlen($word) - 1];
            }
    
            // Cập nhật vị trí gợi ý tiếp theo
            session(["hint_index_$id" => $hintIndex + 1]);
            session(["hint_$id" => $hint]);
        }
    
        return response()->json(['hint' => implode(' ', $hint)]);
    }

    public function showAnswer($id) {
        $audio = Audios::findOrFail($id);
        return response()->json(['answer' => $audio->answer_correct]);
    }    
}