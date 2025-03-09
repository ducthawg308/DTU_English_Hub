@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card shadow-lg border-1 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Thêm topic</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/exercise/store-topic') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select" name="level" id="floatingSelect">
                        <option value="">Chọn level</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                        </select>
                        <label for="floatingSelect">Level</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputTitle" name="name" type="text" placeholder="Title" />
                        <label for="inputTitle">Tên topic</label>
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputTitle" name="desc" type="text" placeholder="Title" />
                        <label for="inputTitle">Mô tả topic</label>
                        @error('desc')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPrice" name="price" type="number" placeholder="Giá bán" />
                        <label for="inputPrice">Giá bán</label>
                        @error('price')
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