<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Vocabulary;
use App\Models\TopicVocabulary;
use App\Models\TypeTopic;
use App\Models\TypeVocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminVocabularyController extends Controller
{
    function list(){
        $vocabularys = Vocabulary::whereHas('topicVocabulary', function ($query) {
            $query->whereNull('user_id');
        })->with(['topicVocabulary', 'typeVocabulary'])->get();
        
        return view('admin.vocabulary.list',compact('vocabularys'));
    }

    function addtopic(){
        $types = TypeTopic::all();
        return view('admin.vocabulary.addtopic', compact('types'));
    }

    function storetopic(Request $request){
        TopicVocabulary::create([
            'name' => $request->input('nameTopic'),
            'type_id' => $request->input('type_id'),
        ]);

        return redirect('admin/vocabulary/list')->with('status','Thêm topic thành công!');
    }

    function addvocab(){
        $topics = TopicVocabulary::whereNull('user_id')->get();
        $types = TypeVocabulary::all();
        return view('admin.vocabulary.addvocab', compact('topics', 'types'));
    }    

    function storevocab(Request $request){
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $destinationPath = public_path('img/vocab');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move($destinationPath, $fileName);

            Vocabulary::create([
                'word' => $request->input('word'),
                'pronounce' => $request->input('pronounce'),
                'meaning' => $request->input('meaning'),
                'example' => $request->input('example'),
                'topic_id' => $request->input('topic'),
                'type_id' => $request->input('type'),
                'image' => $fileName,
            ]);
        }
        return redirect('admin/vocabulary/list')->with('status','Thêm từ vựng thành công!');
    }

    function edit($id){
        $vocab = Vocabulary::find($id);
        $types = TypeVocabulary::all();
        $topics = TopicVocabulary::whereNull('user_id')->get();
        return view('admin.vocabulary.edit',compact('vocab', 'types', 'topics'));
    }

    function delete($id){
        try {
            $vocab = Vocabulary::findOrFail($id); // Sử dụng findOrFail để tự động báo lỗi nếu không tìm thấy
            
            if ($vocab->image) {
                $filePath = public_path('img/vocab/' . $vocab->image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
    
            $vocab->delete();
    
            return redirect('admin/vocabulary/list')->with('status', 'Xóa từ vựng thành công!');
        } catch (\Exception $e) {
            return redirect('admin/vocabulary/list')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    function update(Request $request, $id) {
        // Validate dữ liệu
        $request->validate([
            'word' => 'required|string|max:255',
            'pronounce' => 'nullable|string|max:255',
            'meaning' => 'required|string',
            'example' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $vocab = Vocabulary::findOrFail($id);
    
        $updateData = [
            'word' => $request->input('word'),
            'pronounce' => $request->input('pronounce'),
            'meaning' => $request->input('meaning'),
            'example' => $request->input('example'),
            'topic_id' => $request->input('topic'),
            'type_id' => $request->input('type'),
        ];
    
        if ($request->hasFile('image')) {
            if (!empty($vocab->image) && file_exists(public_path('img/vocab/' . $vocab->image))) {
                unlink(public_path('img/vocab/' . $vocab->image));
            }
    
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('img/vocab'), $imageName);
    
            $updateData['image'] = $imageName;
        }
    
        $vocab->update($updateData);
    
        return redirect('admin/vocabulary/list')->with('status', 'Sửa từ vựng thành công!');
    }
}
