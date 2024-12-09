@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Quản lý bài nghe</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">DailyDictation</a></li>
            <li class="breadcrumb-item active">Quản lý bài nghe</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <a href="{{url('admin/exercise/add-topic')}}" class="btn btn-success">Thêm topic<i class="fa-solid fa-plus"></i></a>
                <a href="{{url('admin/exercise/add-exercise')}}" class="btn btn-success">Thêm exerccise<i class="fa-solid fa-plus"></i></a>
                <a href="{{url('admin/exercise/add')}}" class="btn btn-success">Thêm audio<i class="fa-solid fa-plus"></i></a>
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
                Danh sách bài nghe
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Topic</th>
                            <th>Title</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Topic</th>
                            <th>Title</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                
                        @foreach ($exercises as $exercise)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                <td>{{$t}}</td>
                                <td>{{$exercise->topic->name}}</td>
                                <td>{{$exercise->title}}</td>
                                <td><a href="{{route('edit.exercise',$exercise->id)}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td>
                                    <a href="{{route('delete_exercise',$exercise->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bài nghe này?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
@endsection