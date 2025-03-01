@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-1 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Sửa người dùng</h3></div>
            <div class="card-body">
                <form method="POST" action="{{route('update.user',$user->id)}}">
                @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputName" name="name" type="text" value="{{$user->name}}" placeholder="FullName" />
                        <label for="inputEmail">Họ và tên</label>
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEmail" name="email" type="email" value="{{$user->email}}" disabled placeholder="name@example.com" />
                        <label for="inputEmail">Email</label>
                        @error('email')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                        <label for="inputPassword">Mật khẩu</label>
                        @error('password')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPassword-Confirm" name="password_confirmation" type="password" placeholder="Password confirm" />
                        <label for="inputPassword-Confirm">Nhập lại mật khẩu</label>
                        @error('password_confirmation')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="role" id="floatingSelect">
                            <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Người dùng</option>
                            <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin</option>
                        </select>
                        <label for="floatingSelect">Nhóm quyền</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="status" id="floatingSelect">
                            <option value="1"{{ $user->email_verified_at == "" ? 'selected' : '' }}>Chưa kích hoạt</option>
                            <option value="2"{{ $user->email_verified_at != "" ? 'selected' : '' }}>Đã kích hoạt</option>
                        </select>
                        <label for="floatingSelect">Trạng thái</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit" value="Thêm mới" name="btn-add">Sửa người dùng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection