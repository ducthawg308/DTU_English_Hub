<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Vocabulary;
use App\Models\TopicVocabulary;
use App\Models\TypeVocabulary;
use Illuminate\Http\Request;

class AdminVocabularyController extends Controller
{
    function list(){
        $vocabularys = Vocabulary::whereHas('topicVocabulary', function ($query) {
            $query->whereNull('user_id');
        })->with(['topicVocabulary', 'typeVocabulary'])->get();
        
        return view('admin.vocabulary.list',compact('vocabularys'));
    }

    function addtopic(){
        return view('admin.vocabulary.addtopic');
    }

    function storetopic(Request $request){
        TopicVocabulary::create([
            'name' => $request->input('nameTopic'),
        ]);

        return redirect('admin/vocabulary/list')->with('status','Thêm topic thành công!');
    }

    function addvocab(){
        $topics = TopicVocabulary::whereNull('user_id')->get();
        $types = TypeVocabulary::all();
        return view('admin.vocabulary.addvocab', compact('topics', 'types'));
    }    

    function storevocab(Request $request){
        Vocabulary::create([
            'word' => $request->input('word'),
            'pronounce' => $request->input('pronounce'),
            'meaning' => $request->input('meaning'),
            'example' => $request->input('example'),
            'topic_id' => $request->input('topic'),
            'type_id' => $request->input('type'),
        ]);
        return redirect('admin/vocabulary/list')->with('status','Thêm từ vựng thành công!');
    }

    function edit($id){
        $vocab = Vocabulary::find($id);
        $types = TypeVocabulary::all();
        $topics = TopicVocabulary::whereNull('user_id')->get();
        return view('admin.vocabulary.edit',compact('vocab', 'types', 'topics'));
    }

    function delete($id){
        $vocab = Vocabulary::find($id);
        $vocab->delete();
        return redirect('admin/vocabulary/list')->with('status','Xóa từ vựng thành công!');
    }
    
    function update(Request $request,$id){

        Vocabulary::where('id', $id)->update([
            'word' => $request->input('word'),
            'pronounce' => $request->input('pronounce'),
            'meaning' => $request->input('meaning'),
            'example' => $request->input('example'),
            'topic_id' => $request->input('topic_id'),
            'type_id' => $request->input('type_id'),
        ]);

        return redirect('admin/vocabulary/list')->with('status', 'Sửa từ vựng thành công!');
    }
}
