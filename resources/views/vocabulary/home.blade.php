@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('topic.vocabulary') }}" class="btn btn-primary">Học từ vựng có sẵn của hệ thống</a>
        <a href="{{ route('custom.vocabulary') }}" class="btn btn-primary">Tự custom hệ thống tự vựng của riêng bạn</a>
    </div>
@endsection