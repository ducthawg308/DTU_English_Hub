@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-0 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Sửa bài nghe</h3></div>
            <div class="card-body">
                <form method="POST" action="{{route('update.exercise',$exercise->id)}}" enctype="multipart/form-data">
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

                    @foreach ($audios as $index => $audio)
                        <div class="border border-2 border-primary mb-4 rounded">
                            <div class="form-floating mb-3">
                                <input type="file" name="audio[{{ $index }}]" id="audio_{{ $index }}" accept="audio/*" class="form-control">
                                <label for="audio_{{ $index }}" class="form-label">Chọn bài nghe thay thế:</label>
                                
                                @if($audio->audio)
                                    <audio controls class="mt-2">
                                        <source src="{{ asset('storage/audio/' . $audio->audio) }}" type="audio/mpeg">
                                        Trình duyệt của bạn không hỗ trợ phát file âm thanh.
                                    </audio>
                                @else
                                    <p>Chưa có file âm thanh.</p>
                                @endif
                                
                                @error("audio.$index")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputAnswer_{{ $index }}" value="{{ $audio->answer_correct }}" 
                                    name="answer_correct[{{ $index }}]" type="text" placeholder="Answer Correct">
                                <label for="inputAnswer_{{ $index }}">Đáp án</label>
                                @error("answer_correct.$index")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <a href="{{route('delete_audio',$audio->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa audio này?')"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    @endforeach

                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit" value="Thêm mới" name="btn-add">Sửa bài nghe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection