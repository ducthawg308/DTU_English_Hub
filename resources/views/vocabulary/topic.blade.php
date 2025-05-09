@extends('layouts.app')

@section('content')
    <div class="container px-2 px-sm-4 px-lg-5 my-4 my-md-5" style="min-height: 70vh;">
        <!-- Hero Section -->
        <div class="card shadow border-0 rounded-4 mb-5 mt-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-lg-8 p-4 p-md-5">
                        @if ($isCustoms)
                            <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill">Từ Vựng Tùy Chỉnh</span>
                            <h2 class="card-title fw-bold text-primary mb-3">Tự Tạo Danh Sách Từ Vựng VSTEP</h2>
                            <p class="text-success mb-4 fs-6">Thiết kế bộ từ vựng theo trình độ và mục tiêu riêng của bạn để ôn thi VSTEP hiệu quả hơn.</p>
                        @else
                            <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill">Từ Vựng Hệ Thống</span>
                            <h2 class="card-title fw-bold text-primary mb-3">Học Từ Vựng Theo Cấp Độ VSTEP</h2>
                            <p class="text-success mb-4 fs-6">Từ vựng được phân loại khoa học theo các cấp độ A2, B1, B2, C1 phù hợp với chuẩn đề thi VSTEP.</p>
                        @endif
                        <a href="#levels" class="btn btn-lg btn-primary px-4 rounded-pill">Bắt Đầu Ôn Tập</a>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block bg-primary-subtle">
                        <div class="d-flex justify-content-center align-items-center h-100 p-4">
                            <img src="{{ asset('img/vstep.png') }}" alt="Vocabulary Learning" class="img-fluid rounded mb-4 mb-lg-0" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Levels Section -->
        <h3 class="fw-bold mb-4 text-center" id="levels">Chọn Cấp Độ VSTEP Của Bạn</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            @foreach ($levels as $level)
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 rounded-4 hover-shadow transition-all">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <span class="fs-4 fw-bold text-primary">{{ $level->name }}</span>
                                </div>
                                <div>
                                    <h5 class="card-title fw-semibold text-dark mb-1">Trình Độ {{ $level->name }}</h5>
                                    <p class="text-muted small mb-0">{{ $level->word_count ?? 'Nhiều' }} từ vựng phù hợp VSTEP</p>
                                </div>
                            </div>
                            <p class="text-muted flex-grow-1">{{ $level->description ?? 'Luyện tập các từ vựng trọng điểm cho trình độ ' . $level->name . ' với các chủ đề thường gặp trong đề thi VSTEP.' }}</p>
                            <div class="d-flex mt-3">
                                <a href="{{ route('learnVocab', $level->id) }}" class="btn btn-primary flex-grow-1 rounded-pill">Bắt Đầu Học</a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 p-0">
                            <div class="progress" style="height: 6px; border-radius: 0 0 16px 16px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $level->progress ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Info Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-0 bg-light shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-lightbulb-fill text-warning fs-4 me-3"></i>
                            <h5 class="fw-bold mb-0">Chiến Lược Ôn Từ Vựng</h5>
                        </div>
                        <p class="mb-0">Áp dụng phương pháp lặp lại ngắt quãng (Spaced Repetition) và thực hành ngữ cảnh để ghi nhớ lâu dài. Hãy học đều đặn mỗi ngày.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 bg-light shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-graph-up-arrow text-success fs-4 me-3"></i>
                            <h5 class="fw-bold mb-0">Theo Dõi Tiến Độ</h5>
                        </div>
                        <p class="mb-0">Website tự động lưu tiến độ học của bạn tại mỗi cấp độ. Bạn có thể xem lại số từ đã học, đang học và cần ôn lại.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
@endsection