@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-lg mt-1">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Thêm topic</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ url('home/vocabulary/custom/addtopic/storetopic') }}">
                @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputName" name="nameTopic" type="text" placeholder="Name Topic" />
                        <label for="inputEmail">Tên topic</label>
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button class="btn btn-primary" type="submit" value="Thêm mới" name="btn-add">Thêm topic</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection