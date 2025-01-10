<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;

class AdminVocabularyController extends Controller
{
    function list(){
        $vocabularys = Vocabulary::with(['topicVocabulary', 'typeVocabulary'])->get();
        return view('admin.vocabulary.list',compact('vocabularys'));
    }

    function add(){
        return view('admin.vocabulary.add');
    }

    function edit($id){
        $vocab = Vocabulary::find($id);
        return view('admin.vocabulary.edit',compact('vocab'));
    }

    // function update(Request $request,$id){
    //     $request->validate(
    //         [
    //             'name' => ' string | max:255',
    //         ],
    //         [
    //             'requide' => ':attribute không được để trống',
    //             'min' => ':attribute có độ dài ít nhất :min ký tự',
    //             'max' => ':attribute có độ dài tối đa :max ký tự',
    //             'confirmed' => 'Mật khẩu nhập lại không đúng',    
    //         ],
    //         [
    //             'name' => 'Họ và tên',
    //             'password' => 'Mật khẩu',
    //         ]
    //     );

    //     User::where('id', $id)->update([
    //         'name' => $request->input('name'),
    //         'role_id' => $request->input('role'),
    //     ]);

    //     if(!empty($request->input('password'))){
    //         User::where('id', $id)->update([
    //             'password' => Hash::make($request->input('password')),
    //         ]);
    //     }

    //     if($request->input('status')==1){
    //         User::where('id', $id)->update([
    //             'email_verified_at' => null,
    //         ]);
    //     }else{
    //         User::where('id', $id)->update([
    //             'email_verified_at' => now(),
    //         ]);
    //     }

    //     return redirect('admin/users/list')->with('status', 'Sửa người dùng thành công!');
    // }

    function delete($id){
        $vocab = Vocabulary::find($id);
        $vocab->delete();
        return redirect('admin/vocabulary/list')->with('status','Xóa từ vựng thành công!');
    }
}
