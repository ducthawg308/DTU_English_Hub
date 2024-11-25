<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdminUsersController extends Controller
{
    //
    function list(){
        $users = User::all();   
        return view('admin.users.list', compact('users'));
    }

    function add(){
        return view('admin.users.add');
    }
    
    function store(Request $request){
        $request->validate(
            [
                'name' => 'required | string | max:255',
                'email' => 'required | string | email | max:255 | unique:users',
                'password' => 'required | string | min:8 | confirmed', 
            ],
            [
                'requide' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'Mật khẩu nhập lại không đúng',    
            ],
            [
                'name' => 'Họ và tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role'),
            'email_verified_at' => $request->input('status') == 2 ? now() : null,
        ]);

        return redirect('admin/users/list')->with('status','Thêm người dùng thành công!');
    }

    function delete($id){
        if(Auth::id()!=$id){
            $user = User::find($id);
            $user->delete();
            return redirect('admin/users/list')->with('status','Xóa user thành công!');
        }else{
            return redirect('admin/users/list')->with('status','Bạn không thể xóa chính mình ra khỏi hệ thống!');
        }
    }

    function edit($id){
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    function update(Request $request,$id){
        $request->validate(
            [
                'name' => ' string | max:255',
            ],
            [
                'requide' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'Mật khẩu nhập lại không đúng',    
            ],
            [
                'name' => 'Họ và tên',
                'password' => 'Mật khẩu',
            ]
        );

        User::where('id', $id)->update([
            'name' => $request->input('name'),
            'role_id' => $request->input('role'),
        ]);

        if(!empty($request->input('password'))){
            User::where('id', $id)->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        if($request->input('status')==1){
            User::where('id', $id)->update([
                'email_verified_at' => null,
            ]);
        }else{
            User::where('id', $id)->update([
                'email_verified_at' => now(),
            ]);
        }

        return redirect('admin/users/list')->with('status', 'Sửa người dùng thành công!');
    }
}
