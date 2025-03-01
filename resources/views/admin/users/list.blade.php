@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-2">Quản lý người dùng</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">DailyDictation</a></li>
            <li class="breadcrumb-item active">Quản lý người dùng</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <a href="{{url('admin/users/add')}}" class="btn btn-success">Thêm người dùng <i class="fa-solid fa-plus"></i></a>
            </div>
        </div>
        @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Danh sách người dùng
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                
                        @foreach ($users as $user)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                <td>{{$t}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{ $user->role_id == 1 ? 'Admin' : 'Người dùng' }}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    {!! $user->email_verified_at 
                                        ? '<button type="button" class="btn btn-success">Đã kích hoạt</button>' 
                                        : '<button type="button" class="btn btn-secondary">Chưa kích hoạt</button>' !!}
                                </td>
                                <td><a href="{{route('edit.user',$user->id)}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td>
                                    @if(Auth::id()!=$user->id)
                                        <a href="{{route('delete_user',$user->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa user này?')"><i class="fa-solid fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
@endsection
