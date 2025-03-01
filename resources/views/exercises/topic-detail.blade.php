@extends('layouts.app')
@section('content')
    <div class="container px-4 px-lg-5">
        <div class="card shadow border-0 mb-4 mt-4">
            <div class="card-body text-center">
                <h3 class="card-title text-primary fw-bold">{{ $topic->name }}</h3>
                <p class="text-muted">Danh sách bài nghe trong chủ đề này</p>
            </div>
        </div>

        <div class="list-group">
            @foreach ($topic->listeningExercises as $index => $exercise)
                <a 
                    href="{{ $index == 0 || $isPurchased ? route('topic.listening', ['topicId' => $topic->id, 'id' => $exercise->id]) : '#' }}" 
                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
                    {{ $index > 0 && !$isPurchased ? 'disabled text-muted' : '' }}"
                >
                    <span>{{ $exercise->title }}</span>
                    @if ($index > 0 && !$isPurchased)
                        <span class="badge bg-secondary">Mua để mở khóa</span>
                    @else
                        <span class="badge bg-success">Truy cập</span>
                    @endif
                </a>    
            @endforeach
        </div>
    </div>
@endsection
