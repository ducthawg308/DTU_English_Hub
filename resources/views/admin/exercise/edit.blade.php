@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-0 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Sửa bài nghe</h3></div>
            <div class="card-body">
                <form method="POST" action="{{route('update.exercise',$exercise->id)}}">
                @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select" name="topic" id="floatingSelect">
                            <option value="">Chọn chủ đề</option>
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}" 
                                    @if($topic->id == $exercise->topic_id) selected @endif>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Topic</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputTitle" name="title" value="{{$exercise->title}}" type="text" placeholder="Title" />
                        <label for="inputTitle">Tiêu đề</label>
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputAnswer" value="{{$exercise->answer_text}}" name="answer_text" type="text" placeholder="Answer" />
                        <label for="inputAnswer">Đáp án</label>
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit" value="Thêm mới" name="btn-add">Sửa bài nghe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection