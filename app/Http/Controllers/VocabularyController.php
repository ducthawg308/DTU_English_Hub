<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopicVocabulary;
use App\Models\Wordnote;
use App\Models\TypeVocabulary;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    function home(){
        return view('vocabulary.home');
    }
    
    function topic(){
        $topics = TopicVocabulary::where('user_id', 18)->get();
        return view('vocabulary.topic',compact('topics'));
    }

    function topiccustom(){
        $userId = Auth::id();
        $topics = TopicVocabulary::where('user_id', $userId)->get();
        return view('vocabulary.topic',compact('topics'));
    }

    function custom(){
        $userId = Auth::id();
        $vocabularys = Vocabulary::where('user_id', $userId)->with(['typeVocabulary', 'topicVocabulary'])->get();
        return view('vocabulary.custom',compact('vocabularys'));
    }

    function default($id){
        $vocabularys = Vocabulary::where('topic_id', $id)->with('typeVocabulary')->get();
        return view('vocabulary.default',compact('vocabularys'));
    }

    function learncustom($id){
        $vocabularys = Vocabulary::where('topic_id', $id)->with('typeVocabulary')->get();
        return view('vocabulary.default',compact('vocabularys'));
    }

    function addtopic(){
        return view('vocabulary.custom.addtopic');
    }
    
    function storetopic(Request $request){
        $userId = Auth::id();
        TopicVocabulary::create([
            'name' => $request->input('nameTopic'),
            'user_id' => $userId,
        ]);

        return redirect('home/vocabulary/custom')->with('status','Thêm topic thành công!');
    }

    function addvocab(){
        $userId = Auth::id();
        $topics = TopicVocabulary::where('user_id', $userId)->get();
        $types = TypeVocabulary::all();
        return view('vocabulary.custom.addvocab', compact(['topics','types']));
    }

    function storevocab(Request $request){
        $userId = Auth::id();
        Vocabulary::create([
            'user_id' => $userId,
            'word' => $request->input('word'),
            'pronounce' => $request->input('pronounce'),
            'meaning' => $request->input('meaning'),
            'example' => $request->input('example'),
            'topic_id' => $request->input('topic'),
            'type_id' => $request->input('type'),
        ]);
        return redirect('home/vocabulary/custom')->with('status','Thêm từ vựng thành công!');
    }   

    function delete($id){
        $vocabulary = Vocabulary::find($id);
        if ($vocabulary) {
            $vocabulary->delete();

            return redirect('home/vocabulary/custom')->with('status', 'Xóa bài từ vựng thành công!');
        }

        return redirect('home/vocabulary/custom')->with('error', 'Từ vựng không tồn tại!');
    }

    function review($id){
        $vocabularys = Vocabulary::where('topic_id', $id)->with('typeVocabulary')->get();
        return view('vocabulary.review',compact('vocabularys')); 
    }
}
