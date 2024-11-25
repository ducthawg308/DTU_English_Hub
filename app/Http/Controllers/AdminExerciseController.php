<?php

namespace App\Http\Controllers;

use App\Models\ListeningExercise;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminExerciseController extends Controller
{
    function list(){
        $exercises = ListeningExercise::with('topic')->get();
        return view('admin.exercise.list', compact('exercises'));
    }

    function delete($id){
        $exercise = ListeningExercise::find($id);

        if ($exercise) {
            $filePath = 'public/audio/' . $exercise->audio;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $exercise->delete();

            return redirect('admin/exercise/list')->with('status', 'Xóa bài nghe thành công!');
        }

        return redirect('admin/exercise/list')->with('error', 'Bài nghe không tồn tại!');
    }

    function add(){
        $topics = Topic::all();
        return view('admin/exercise/add', compact('topics'));
    }

    function store(Request $request){
        $request->validate([
            'audio' => 'required|mimes:mp3,wav|max:10240',
        ]);
    
        // Lưu file vào storage/app/public/audio
        if ($request->hasFile('audio')) {
            $filePath = $request->file('audio')->store('public/audio'); // Lưu file
            $fileName = basename($filePath); // Chỉ lấy tên file
    
            // Lưu tên file vào cơ sở dữ liệu
            ListeningExercise::create([
                'topic_id' => $request->input('topic'),
                'title' => $request->input('title'),
                'audio' => $fileName,
                'answer_text' => $request->input('answer_text'),
            ]);
        }
    
        return redirect('admin/exercise/list')->with('status', 'Thêm bài nghe thành công!');
    }

    function edit($id){
        $exercise = ListeningExercise::find($id);
        $topics = Topic::all();
        return view('admin.exercise.edit', compact('exercise', 'topics'));
    }

    function update(Request $request,$id){
        $request->validate([
            'topic' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'answer_text' => 'required|string',
        ]);

        ListeningExercise::where('id', $id)->update([
            'topic_id' => $request->input('topic'),
            'title' => $request->input('title'),
            'answer_text' => $request->input('answer_text'),
        ]);

        return redirect('admin/exercise/list')->with('status', 'Sửa bài nghe thành công!');
    }
}
