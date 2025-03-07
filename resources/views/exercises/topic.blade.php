@extends('layouts.app')
@section('content')
    <div class="container">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="{{ asset('img/listen.jpg') }}" alt="..." /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light">Chủ đề luyện nghe tiếng Anh</h1>
                <p> Chọn chủ đề bạn yêu thích và bắt đầu rèn luyện kỹ năng nghe với các bài tập chính tả. Nội dung từ cơ bản đến nâng cao, giúp bạn nâng cấp khả năng nghe một cách hiệu quả!</p>
                <a class="btn btn-primary" href="#!">Bắt đầu ngay!</a>
            </div>
        </div>
        <!-- Content Row-->
        <div class="row gx-4 gx-lg-5"> 
            @foreach ($topics as $topic)
                <div class="col-md-4 mb-5 d-flex">
                    <div class="position-relative bg-white border rounded p-4">
                        @if ($topic->price == 0)
                            <div class="ribbon free"><span>FREE</span></div>
                        @else
                            <div class="ribbon premium"><span>PREMIUM</span></div>
                        @endif
                        <h1 class="h4 fw-bold"><a href="{{ route('topic.show', $topic->id) }}">{{ $topic->name }}</a></h1>
                        <p class="text-success mb-1">Cấp độ: {{ $topic->level->name }}</p>
                        <p class="text-warning mb-3">Số bài học: {{ $topic->listening_exercises_count }} lessons</p>
                        <p class="text-muted mb-4">Mô tả: {{ $topic->desc }}</p>
                    </div>
                </div>  
            @endforeach
        </div>
    </div>
    <style>
        .ribbon {
        position: absolute;
        top: -10px;
        right: -10px;
        overflow: hidden;
        width: 75px;
        height: 75px;
        text-align: right;
        }
        .ribbon span {
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            text-transform: uppercase;
            text-align: center;
            line-height: 20px;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            width: 100px;
            display: block;
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px;
            right: -21px;
        }
        .ribbon.free span {
            background: #28a745; /* Màu xanh lá */
            background: linear-gradient(#28a745 0%, #28a745 100%);
        }
        .ribbon.premium span {
            background:rgb(236, 189, 61); /* Màu vàng */
            background: linear-gradient(#ffc107 0%,rgb(236, 189, 61) 100%);
        }
    </style>
@endsection
