@extends('layouts.app')
@section('content')
    <div class="container px-4 py-4 px-lg-5">
        <div class="card shadow border-0 mb-4 mt-4">
            <div class="card-body px-5">
                <h3 class="card-title text-primary fw-bold">{{ $topic->name }}</h3>
                <p class="text-success mb-2">Cấp độ: {{ $topic->level->name }}</p>
                <p class="text-warning mb-2">Số bài học: {{ $topic->listening_exercises_count }} lessons</p>
                <p class="text-muted mb-3">Mô tả: {{ $topic->desc }}</p>
                @if(!in_array($topic->id, $purchasedTopics))
                    <form method="POST" action="{{ url('/vnpay_payment') }}">
                        @csrf
                        <input hidden type="number" name="price" value="{{ $topic->price }}">
                        <input hidden type="number" name="id_topic" value="{{ $topic->id }}">
                        {!! $topic->price == 0 ? '' : '<button class="btn btn-success btn-sm mb-3" type="submit" name="redirect">Mở khóa tất cả</button>' !!}
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm mb-3" disabled>Đã mở khóa</button>
                @endif
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="list-group">
            @foreach ($topic->listeningExercises as $index => $exercise)
                @php
                    $isUnlocked = $isPurchased || $index < 3; // Cho phép xem nếu đã mua hoặc là 3 bài đầu
                @endphp
                <a 
                    href="{{ $isUnlocked ? route('topic.listening', ['topicId' => $topic->id, 'id' => $exercise->id]) : '#' }}" 
                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
                    {{ !$isUnlocked ? 'disabled text-muted' : '' }}"
                >
                    <span>{{ $exercise->title }}</span>
                    @if (!$isUnlocked)
                        <span class="badge bg-secondary p-2"><i class="fa-solid fa-lock"></i></span>
                    @else
                        <span class="badge bg-success p-2"><i class="fa-solid fa-lock-open"></i></span>
                    @endif
                </a>    
            @endforeach
        </div>
    </div>
@endsection
