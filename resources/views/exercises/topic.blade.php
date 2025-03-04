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
        <!-- Call to Action-->
        <div class="card text-white bg-secondary my-5 py-3 text-center">
            <div class="card-body"><h2 class="text-white">All topic</h2></div>
        </div>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <!-- Content Row-->
        <div class="row gx-4 gx-lg-5"> 
            @foreach ($topics as $topic)
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">{{ $topic->name }}</h2>
                            <p class="text-success">Cấp độ: {{ $topic->level->name }}</p>
                            <p class="text-warning">Số bài học: {{ $topic->total_less }} lessons</p>
                            <p class="card-text">Mô tả: {{ $topic->desc }}</p>
                            <p class="text-danger fw-bold">
                                Giá: {{ $topic->price == 0 ? 'Free' : number_format($topic->price, 0, ',', '.') . 'đ' }}
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-primary btn-sm" href="{{ route('topic.show', $topic->id) }}">Xem chi tiết</a>
                            @if(!in_array($topic->id, $purchasedTopics))
                                <form method="POST" action="{{ url('/vnpay_payment') }}">
                                    @csrf
                                    <input hidden type="number" name="price" value="{{ $topic->price }}">
                                    <input hidden type="number" name="id_topic" value="{{ $topic->id }}">
                                    {!! $topic->price == 0 ? '' : '<button class="btn btn-primary btn-sm" type="submit" name="redirect">Mua bài học</button>' !!}
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Đã mua</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
