@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-1 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Thêm audio</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/exercise/store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select" name="exercise" id="floatingSelect">
                        <option value="">Chọn exercise</option>
                        @foreach ($exercises as $exercise)
                            <option value="{{ $exercise->id }}">{{$exercise->title}}</option>
                        @endforeach
                        </select>
                        <label for="floatingSelect">Exercise</label>
                    </div>  
                    <div class="form-floating mb-3">
                        <input type="file" name="audio" id="audio" accept="audio/*" class="form-control" required>
                        <label for="audio" class="form-label">Audio:</label>
                        @error('audio')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="answer_correct" name="answer_correct" type="text" placeholder="Answer correct" />
                        <label for="answer_correct">Answer Correct</label>
                        @error('name')
                            <small class="text- danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit" value="Thêm mới" name="btn-add">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection