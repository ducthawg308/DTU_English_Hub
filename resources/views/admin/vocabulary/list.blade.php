@extends('layouts.admin')
@section('content')
<div class="container-fluid px-4">
        <h1 class="mt-2">Quản lý từ vựng</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">DailyDictation</a></li>
            <li class="breadcrumb-item active">Quản lý từ vựng</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <a href="{{url('admin/vocabulary/addtopic')}}" class="btn btn-success">Thêm topic <i class="fa-solid fa-plus"></i></a>
                <a href="{{url('admin/vocabulary/addvocab')}}" class="btn btn-success">Thêm từ mới <i class="fa-solid fa-plus"></i></a>
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
                Danh sách từ vựng
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Từ</th>
                            <th>Phiên âm</th>
                            <th>Nghĩa</th>
                            <th>Topic</th>
                            <th>Loại từ</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Từ</th>
                            <th>Phiên âm</th>
                            <th>Nghĩa</th>
                            <th>Topic</th>
                            <th>Loại từ</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                
                        @foreach ($vocabularys as $vocab)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                <td>{{$t}}</td>
                                <td>{{$vocab->word}}</td>
                                <td>{{$vocab->pronounce}}</td>
                                <td>{{$vocab->meaning}}</td>
                                <td>{{$vocab->topicVocabulary?->name}}</td>
                                <td>{{$vocab->typeVocabulary?->name}}</td>
                                <td><a href="{{route('edit.vocab',$vocab->id)}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td>
                                    <a href="{{route('delete_vocab',$vocab->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa từ này?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
@endsection