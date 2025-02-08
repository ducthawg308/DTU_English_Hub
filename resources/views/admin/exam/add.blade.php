@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-0 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Thêm bài kiểm tra</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/exam/store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputName" name="name" type="text" placeholder="Tên bài kiểm tra" />
                        <label for="inputName">Tên bài kiểm tra</label>
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputTime" name="time" type="number" placeholder="Thời gian làm bài" />
                        <label for="inputEmail">Thời gian làm bài</label>
                        @error('time')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputTotal" name="total_question" type="number" placeholder="Tổng số câu hỏi" />
                        <label for="inputTotal">Tổng số câu hỏi</label>
                        @error('total_question')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="level" id="floatingSelect">
                        <option value="">Chọn level</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                        </select>
                        <label for="floatingSelect">Level</label>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">File test exam</label>
                        <input class="form-control" type="file" name="file" id="formFile">
                      </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit" value="Thêm mới" name="btn-add">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection