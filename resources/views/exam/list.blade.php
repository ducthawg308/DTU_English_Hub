@extends('layouts.app')

@section('content')
    <div class="container py-5" style="min-height: 80vh;">
        <h1 class="text-center fw-bold mb-5 text-primary">Đề Thi Thử VSTEP – Luyện Thi Chứng Chỉ Tiếng Anh B1, B2, C1</h1>

        <div class="row g-4">
            @foreach ($exams as $exam)
                <div class="col-md-6 col-lg-4">
                    <div class="card exam-card border-0 rounded-4 shadow-lg h-100" style="transition: all 0.3s ease;">
                        <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                            <img src="https://i0.wp.com/lawsblog.london.ac.uk/wp-content/uploads/2017/10/exam-paper.jpg?fit=3648%2C2736&ssl=1" 
                                 class="w-100 h-100 object-fit-cover" 
                                 alt="Exam Image">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">{{ $exam->title }}</h5>
                            <p class="card-text text-muted small mb-2" style="max-height: 4rem; overflow: auto;">
                                Mô tả: {{ $exam->desc }}
                            </p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="badge bg-info text-dark">Cấp độ: {{ $exam->level }}</span>
                                <a href="{{ route('exam.room', $exam->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i> Thi thử
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .exam-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
        }
        .object-fit-cover {
            object-fit: cover;
        }
    </style>
@endsection
