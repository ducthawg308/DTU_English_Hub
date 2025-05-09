@extends('layouts.app')
@section('content')
    <div class="container py-5" style="min-height: 80vh;">
        <!-- Learning Methods Section -->
        <div id="learning-methods" class="row mb-1">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold">Phương pháp học từ vựng</h2>
                <p class="text-muted">Lựa chọn phương pháp học từ vựng phù hợp với bạn</p>
            </div>
        </div>

        <!-- Cards Section -->
        <div class="row g-4">
            <!-- System Vocabulary Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <i class="bi bi-collection-fill fs-1"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Học Từ Vựng Của Hệ Thống</h4>
                        <p class="card-text text-muted mb-4">
                            Khám phá bộ từ vựng được đội ngũ giảng viên Đại học Duy Tân biên soạn, phân loại theo cấp độ VSTEP và các chủ đề thường gặp. Luyện tập từ vựng một cách có hệ thống để nâng cao kỹ năng ngôn ngữ và sẵn sàng cho kỳ thi.
                        </p>
                        <a href="{{ route('topic.vocabulary') }}" class="btn btn-primary px-4 fw-semibold mt-auto">
                            Bắt đầu học <i class="bi bi-book ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Custom Vocabulary Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="text-success mb-3">
                            <i class="bi bi-pencil-square fs-1"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Học Từ Vựng Tự Custom</h4>
                        <p class="card-text text-muted mb-4">
                            Tạo danh sách từ vựng riêng của bạn và học theo cách của bạn. Nhập từ vựng một cách thủ công
                            hoặc sinh từ vựng từ AI, sau đó sử dụng các công cụ học tập để ghi nhớ chúng hiệu quả.
                        </p>
                        <a href="{{ route('custom.vocabulary') }}" class="btn btn-success px-4 fw-semibold mt-auto">
                            Tạo danh sách từ vựng <i class="bi bi-plus-circle ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Spaced Repetition Card -->
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="row g-0">
                        <div class="col-md-4 bg-warning bg-opacity-10">
                            <div class="d-flex align-items-center justify-content-center h-100 p-3">
                                <img src="{{ asset('img/spaced_repetition1.jpg') }}" alt="Spaced Repetition" class="img-fluid" style="max-height: 200px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4 p-lg-5">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-warning-subtle text-warning fs-6 me-2">Khuyên dùng</span>
                                    <h3 class="card-title fw-bold mb-0">Ôn Luyện Theo Phương Pháp Spaced Repetition</h3>
                                </div>
                                <p class="card-text fs-6 text-muted mb-4">
                                    Ứng dụng phương pháp <strong>Spaced Repetition</strong> thông minh giúp bạn ghi nhớ từ vựng hiệu quả hơn. 
                                    Các từ sẽ được phân loại vào các box như "Dễ nhớ", "Dễ quên" và "Rất dễ quên" dựa trên khả năng ghi nhớ của bạn.
                                    Hệ thống sẽ nhắc bạn ôn tập từ vựng đúng thời điểm để tối ưu hóa quá trình học tập.
                                </p>
                                <a href="{{ route('spacedrepetition.vocabulary') }}" class="btn btn-warning px-4 fw-semibold">
                                    Ôn luyện ngay <i class="bi bi-lightning-charge-fill ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection