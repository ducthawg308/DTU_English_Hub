@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-2">Quản lý bài thi thử</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">DTU English Hub</a></li>
            <li class="breadcrumb-item active">Quản lý bài kiểm tra</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <a href="{{url('admin/exam/add')}}" class="btn btn-success">Thêm bài thi <i class="fa-solid fa-plus"></i></a>
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
                Danh sách bài thi thử
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên bài thi</th>
                            <th>Cấp độ</th>
                            <th>Mô tả</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Tên bài thi</th>
                            <th>Cấp độ</th>
                            <th>Mô tả</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
               
                        @foreach ($exams as $exam)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                <td>{{$t}}</td>
                                <td>{{$exam->title}}</td>
                                <td>{{$exam->level}}</td>
                                <td>{{$exam->desc}}</td>
                                <td><a href="{{route('edit.exam',$exam->id)}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td>
                                    <a href="{{route('delete_exam',$exam->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bài thi này?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
@endsection
