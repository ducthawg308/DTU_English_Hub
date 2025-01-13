@extends('layouts.admin')
@section('content')
<div class="container">
        <div class="card shadow-lg border-0 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Sửa từ vựng</h3></div>
            <div class="card-body">
                <form method="POST" action="{{route('update.vocab',$vocab->id)}}">
                @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputWord" name="word" type="text" value="{{$vocab->word}}" placeholder="Từ" />
                        <label for="inputWord">Từ</label>
                        @error('word')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPronounce" name="pronounce" type="text" value="{{$vocab->pronounce}}" placeholder="Phiêm âm" />
                        <label for="inputPronounce">Từ</label>
                        @error('pronounce')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputMeaning" name="meaning" type="text" value="{{$vocab->meaning}}" placeholder="Nghĩa" />
                        <label for="inputMeaning">Nghĩa</label>
                        @error('meaning')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputExample" name="example" type="text" value="{{$vocab->example}}" placeholder="Câu ví dụ" />
                        <label for="inputExample">Câu ví dụ</label>
                        @error('example')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="topic" id="floatingSelect">
                            <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Người dùng</option>
                            <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin</option>
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
                        <select class="form-select" name="type" id="floatingSelect">
                            <option value="1"{{ $user->email_verified_at == "" ? 'selected' : '' }}>Chưa kích hoạt</option>
                            <option value="2"{{ $user->email_verified_at != "" ? 'selected' : '' }}>Đã kích hoạt</option>
                        </select>
                        <label for="floatingSelect">Loại từ</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" ty  pe="submit" value="Thêm mới" name="btn-add">Sửa từ vựng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection