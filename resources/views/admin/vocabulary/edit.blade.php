@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-1 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Sửa từ vựng</h3></div>
            <div class="card-body">
                <form method="POST" action="{{route('update.vocab',$vocab->id)}}">
                @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputVocab" name="word" type="text" value="{{$vocab->word}}" placeholder="Vocab" />
                        <label for="inputVocab">Từ vựng</label>
                        @error('word')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPronounce" name="pronounce" type="text" value="{{$vocab->pronounce}}" placeholder="Pronounce" />
                        <label for="inputPronounce">Phiên âm</label>
                        @error('pronounce')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputMeaningName" name="meaning" type="text" value="{{$vocab->meaning}}" placeholder="Meaning" />
                        <label for="inputMeaning">Nghĩa</label>
                        @error('meaning')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputExample" name="example" type="text" value="{{$vocab->example}}" placeholder="Example" />
                        <label for="inputExample">Câu ví dụ</label>
                        @error('example')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="topic_id" id="topic_id">
                        <option value="">Topic</option>
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}" 
                                    @if($topic->id == $vocab->topic_id) selected @endif>
                                    {{ $topic->name }}
                            </option>
                        @endforeach
                        </select>       
                        <label for="floatingSelect">Topic</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="type_id" id="type_id">
                        <option value="">Loại từ</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" 
                                    @if($type->id == $vocab->type_id) selected @endif>
                                    {{ $type->name }}
                            </option>
                        @endforeach
                        </select>       
                        <label for="floatingSelect">Type</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit" value="Thêm mới" name="btn-add">Sửa từ vựng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection