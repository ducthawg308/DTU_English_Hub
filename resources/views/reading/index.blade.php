@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold">🧠 Luyện Kỹ Năng Đọc Hiểu Tiếng Anh</h2>

    <div class="row g-4">
         <!-- Mục 1: Luyện bài đọc hiểu theo cấp độ VSTEP -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 bg-light">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <span class="display-4">📚</span>
                    </div>
                    <h4 class="fw-bold">Bài đọc hiểu của hệ thống</h4>
                    <p class="mt-3">Lựa chọn bài đọc theo cấp độ VSTEP từ A1 đến C2 để luyện kỹ năng đọc hiểu phù hợp với trình độ và nâng cao vốn từ vựng.</p>

                    <div class="row row-cols-2 row-cols-md-3 g-3 mt-5">
                        @foreach ([
                            ['A1', 'Bắt đầu'],
                            ['A2', 'Sơ cấp'],
                            ['B1', 'Trung cấp'],
                            ['B2', 'Khá'],
                            ['C1', 'Nâng cao'],
                            ['C2', 'Thành thạo'],
                        ] as [$level, $label])
                            <div class="col d-flex">
                                <a href="{{ route('default.reading', ['level' => $level]) }}" class="btn btn-outline-primary rounded-pill w-100 text-center d-flex align-items-center justify-content-center py-3">
                                    VSTEP {{ $level }} - {{ $label }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Mục 2: Tạo bài đọc hiểu từ AI -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 hover-shadow transition bg-light">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3">
                            <span class="display-4">🤖</span>
                        </div>
                        <h4 class="card-title fw-bold">Tạo bài đọc từ AI</h4>
                        <p class="card-text mt-3">
                            Chọn cấp độ và chủ đề, hệ thống AI sẽ tự động tạo ra bài đọc phù hợp để bạn luyện tập hiệu quả và cá nhân hóa trải nghiệm học tập.
                        </p>
                        <a href="{{ route('ai.reading') }}" class="btn btn-success mt-3 px-5 py-2 rounded-pill">
                            Tạo với AI
                        </a>

                        <hr class="my-4">

                        <h6 class="fw-bold text-muted">📌 Hỗ trợ các cấp độ VSTEP:</h6>
                        <div class="d-flex justify-content-center flex-wrap gap-2 mt-2">
                            <span class="badge bg-secondary rounded-pill">A1</span>
                            <span class="badge bg-secondary rounded-pill">A2</span>
                            <span class="badge bg-secondary rounded-pill">B1</span>
                            <span class="badge bg-secondary rounded-pill">B2</span>
                            <span class="badge bg-secondary rounded-pill">C1</span>
                            <span class="badge bg-secondary rounded-pill">C2</span>
                        </div>

                        <h6 class="fw-bold mt-4 text-muted">📚 Gợi ý chủ đề:</h6>
                        <p class="small text-muted">
                            Du lịch, Giáo dục, Sức khỏe, Môi trường, Công nghệ, Văn hóa, Thể thao...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
