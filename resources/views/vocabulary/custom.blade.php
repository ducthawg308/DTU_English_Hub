@extends('layouts.app')
@section('content')
    <div class="container-fluid px-5 my-5" style="min-height: 80vh;">
        <h1 class="mt-4">Quản lý từ vựng custom</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">DailyDictation</a></li>
            <li class="breadcrumb-item active">Quản lý từ vựng custom</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <a href="{{ route('topic.custom') }}" class="btn btn-success">Bắt đầu học <i class="fa-solid fa-book"></i></a>
                <a href="{{ route('addtopic.custom') }}" class="btn btn-success">Thêm topic <i class="fa-solid fa-plus"></i></a>
                <a href="{{ route('addvocab.custom') }}" class="btn btn-success">Thêm từ mới <i class="fa-solid fa-plus"></i></a>
                <a href="{{ route('ai.custom') }}" class="btn btn-success">Tạo từ vựng từ AI <i class="fa-solid fa-robot"></i></a>
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
                Danh sách từ vựng custom
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Từ vựng</th>
                            <th>Phiên âm</th>
                            <th>Nghĩa</th>
                            <th>Câu ví dụ</th>
                            <th>Chủ đề</th>
                            <th>Loại từ</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                        <th>STT</th>
                            <th>Từ vựng</th>
                            <th>Phiên âm</th>
                            <th>Nghĩa</th>
                            <th>Câu ví dụ</th>
                            <th>Chủ đề</th>
                            <th>Loại từ</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $t=0;
                        @endphp
                
                        @foreach ($vocabularys as $vocabulary)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                <td>{{$t}}</td>
                                <td>{{$vocabulary->word}}</td>
                                <td>{{$vocabulary->pronounce}}</td>
                                <td>{{ $vocabulary->meaning }}</td>
                                <td>{{$vocabulary->example}}</td>
                                <td>{{$vocabulary->topicVocabulary->name}}</td>
                                <td>{{$vocabulary->typeVocabulary->name}}</td>
                                <td><a href="{{route('edit.vocabUser',$vocabulary->id)}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td>
                                    <a href="{{ route('delete.custom', $vocabulary->id) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa từ vựng này?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
@endsection