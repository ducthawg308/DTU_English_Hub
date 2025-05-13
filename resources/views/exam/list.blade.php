@extends('layouts.app')

@section('content')
    <div class="container py-5" style="min-height: 80vh;">
        <h1 class="text-center fw-bold mb-5">Danh sách bài thi thử</h1>

        <div class="row g-4">
            @foreach ($exams as $exam)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100 exam-card" style="transition: transform 0.2s;">
                        <img src="https://i0.wp.com/lawsblog.london.ac.uk/wp-content/uploads/2017/10/exam-paper.jpg?fit=3648%2C2736&ssl=1" class="card-img-top" alt="Exam Image" style="height: 210px; object-fit: cover; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title fw-bold">{{ $exam->title }}</h5>
                            <p class="card-text small text-muted">Mô tả: {{ $exam->desc }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">Cấp độ: {{ $exam->level }}</span>
                                <a href="{{ route('exam.room', $exam->id) }}" class="btn btn-warning btn-sm">Thi thử</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .exam-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
