<?php

namespace App\Http\Controllers;

use App\Models\Audios;
use App\Models\Level;
use App\Models\ListeningExercise;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Queue\ListenerOptions;

class AdminExerciseController extends Controller
{
    function list(){
        $exercises = ListeningExercise::with('topic')->get();
        return view('admin.exercise.list', compact('exercises'));
    }

    function delete($id){
        $exercise = ListeningExercise::find($id);

        if ($exercise) {
            $exercise->delete();

            return redirect('admin/exercise/list')->with('status', 'Xóa bài nghe thành công!');
        }

        return redirect('admin/exercise/list')->with('error', 'Bài nghe không tồn tại!');
    }

    function delete_audio($id){
        $audio = Audios::find($id);

        if ($audio) {
            $filePath = 'public/audio/' . $audio->audio;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $audio->delete();

            return redirect('admin/exercise/list')->with('status', 'Xóa audio thành công!');
        }

        return redirect('admin/exercise/list')->with('error', 'Bài nghe không tồn tại!');
    }

    function add_topic(){
        $levels = Level::all();
        return view('admin/exercise/add-topic', compact('levels'));
    }

    function add_exercise(){
        $topics = Topic::all();
        return view('admin/exercise/add-exercise', compact('topics'));
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
            Audios::create([
                'listening_id' => $request->input('exercise'),
                'audio' => $fileName,
                'answer_correct' => $request->input('answer_correct'),
            ]);
        }
    
        return redirect('admin/exercise/list')->with('status', 'Thêm bài nghe thành công!');
    }

    function store_topic(Request $request){
                
        Topic::create([
            'level_id' => $request->input('level'),
            'name' => $request->input('name'),
            'total_less' => $request->input('total_less'),
            'desc' => $request->input('desc'),
        ]);
    
        return redirect('admin/exercise/list')->with('status', 'Thêm topic thành công!');
    }

    function store_exercise(Request $request){
        $id_topic = $request->input('topic');
        $exercises = ListeningExercise::where('topic_id', $id_topic)->get();
        return view('admin.exercise.add-audio', compact('exercises'));
    }

    function store_exercise1(Request $request){
        ListeningExercise::create([
            'topic_id' => $request->input('topic'),
            'title' => $request->input('title'),
        ]);
    
        return redirect('admin/exercise/list')->with('status', 'Thêm exercise thành công!');
    }

    function edit($id){
        $exercise = ListeningExercise::find($id);   
        $audios = Audios::where('listening_id', $id)->get();
        $topics = Topic::all();
        return view('admin.exercise.edit', compact('exercise', 'topics', 'audios'));
    }

    function update(Request $request, $id){
        // Validate dữ liệu
        $request->validate([
            'topic' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'answer_correct' => 'required|array',
            'answer_correct.*' => 'required|string',
            'audio' => 'nullable|array',
            'audio.*' => 'nullable|file|mimes:mp3,wav|max:2048',
        ]);
    
        // Lấy bài nghe
        $exercise = ListeningExercise::findOrFail($id);
        $exercise->update([
            'topic_id' => $request->input('topic'),
            'title' => $request->input('title'),
        ]);
    
        // Xử lý từng audio
        $audios = Audios::where('listening_id', $id)->get();
        $answers = $request->input('answer_correct');
        $files = $request->file('audio');
    
        foreach ($audios as $index => $audio) {
            $audioData = ['answer_correct' => $answers[$index]];
    
            // Nếu có file mới, lưu và cập nhật
            if ($files && isset($files[$index])) {
                if (!empty($audio->audio) && Storage::exists('public/audio/' . $audio->audio)) {
                    Storage::delete('public/audio/' . $audio->audio);
                }
    
                $filePath = $files[$index]->store('public/audio');
                $audioData['audio'] = basename($filePath);
            }
            $audio->update($audioData);
        }
    
        return redirect('admin/exercise/list')->with('status', 'Cập nhật bài nghe thành công!');
    }
}
