@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-1 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Thêm bài kiểm tra</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/exam/store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputTitle" name="title" type="text" placeholder="Tên bài kiểm tra" />
                        <label for="inputTitle">Tên bài kiểm tra</label>
                        @error('title')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="inputDesc" name="desc" placeholder="Mô tả bài kiểm tra" style="height: 100px"></textarea>
                        <label for="inputDesc">Mô tả</label>
                        @error('desc')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="level" id="floatingSelect">
                            <option value="">Chọn level</option>
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="C1">C1</option>
                            <option value="C2">C2</option>
                        </select>
                        <label for="floatingSelect">Level</label>
                        @error('level')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">File test exam (Excel)</label>
                        <input class="form-control" type="file" name="file" id="formFile">
                        @error('file')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" name="audio" id="audio" accept="audio/*" class="form-control" required>
                        <label for="audio" class="form-label">Audio:</label>
                        @error('audio')
                            <small class="text-danger">{{$message}}</small>
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