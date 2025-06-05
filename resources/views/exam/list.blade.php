@extends('layouts.app')

@section('content')
    <div class="container py-5" style="min-height: 80vh;">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="fw-bold mb-3 text-dark">Thi Thử VSTEP Miễn Phí</h1>
            <p class="text-muted">Luyện Thi Chứng Chỉ Tiếng Anh B1, B2, C1</p>
        </div>

        <!-- Exams Grid -->
        <div class="row g-4">
            @foreach ($exams as $exam)
                <div class="col-md-6 col-lg-4">
                    <div class="card exam-card h-100 border-0 shadow-sm">
                        <!-- Image -->
                        <div class="position-relative">
                            <img src="https://i0.wp.com/lawsblog.london.ac.uk/wp-content/uploads/2017/10/exam-paper.jpg?fit=3648%2C2736&ssl=1" 
                                 class="card-img-top exam-img" 
                                 alt="Exam"
                                 style="height: 200px; object-fit: cover;">
                            
                            <!-- Level Badge -->
                            <span class="position-absolute top-0 end-0 m-3 badge bg-primary rounded-pill px-3 py-2">
                                {{ $exam->level }}
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold mb-3">{{ $exam->title }}</h5>
                            
                            <p class="card-text text-muted small mb-4 flex-grow-1">
                                {{ $exam->desc }}
                            </p>

                            <!-- Action Button -->
                            <a href="{{ route('exam.room', $exam->id) }}" 
                               class="btn btn-primary rounded-pill">
                                <i class="bi bi-play-circle me-2"></i>
                                Bắt đầu thi
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($exams) === 0)
            <div class="text-center py-5">
                <p class="text-muted">Chưa có đề thi nào.</p>
            </div>
        @endif
    </div>

    <style>
        .exam-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        .exam-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .exam-img {
            transition: transform 0.3s ease;
        }

        .exam-card:hover .exam-img {
            transform: scale(1.05);
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
        }
    </style>
@endsection