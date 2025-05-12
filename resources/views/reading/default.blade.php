@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header with decorative elements -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="mb-4">
                <span class="display-6 fw-bold text-primary">
                    <i class="fas fa-book-open me-2"></i>Danh sách bài đọc
                </span>
            </div>
            <h2 class="h3 text-secondary">
                Trình độ <span class="badge bg-primary px-3 py-2 rounded-pill fs-6">{{ strtoupper($readings->first()->level ?? $level ?? 'N/A') }}</span>
            </h2>
        </div>
    </div>

    <!-- Empty state with illustration -->
    @if($readings->isEmpty())
        <div class="row justify-content-center my-5">
            <div class="col-md-6 text-center">
                <div class="mb-4">
                    <svg width="160" height="160" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        <circle cx="12" cy="12" r="4"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </div>
                <h3 class="h4 text-secondary">Không tìm thấy bài đọc</h3>
                <p class="text-muted mb-4">Hiện tại chưa có bài đọc nào ở trình độ này. Vui lòng thử lại sau hoặc chọn trình độ khác.</p>
                <a href="{{ route('index.reading') }}" class="btn btn-outline-primary px-4">Quay lại</a>
            </div>
        </div>
    @else
        <!-- Reading list with improved cards -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($readings as $reading)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-3 hover-card">
                        <!-- Card header with image placeholder -->
                        <div class="card-img-top bg-light rounded-top p-4 text-center">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>
                        
                        <!-- Card body with content -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $reading->level }}</span>
                                <span class="badge bg-light text-dark"><i class="far fa-clock me-1"></i> 5 phút</span>
                            </div>
                            <h5 class="card-title fw-bold">{{ $reading->title }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($reading->description ?? 'Bài đọc giúp nâng cao vốn từ vựng và khả năng đọc hiểu.', 80) }}
                            </p>
                            
                            <!-- Tags -->
                            <div class="mb-3">
                                <span class="badge bg-light text-secondary me-1">Từ vựng</span>
                                <span class="badge bg-light text-secondary">Ngữ pháp</span>
                            </div>
                        </div>
                        
                        <!-- Card footer -->
                        <div class="card-footer bg-white border-0 pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted"><i class="far fa-eye me-1"></i>1</small>
                                </div>
                                <a href="{{ route('detail.reading', $reading->id) }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-book-reader me-1"></i> Đọc ngay
                                </a>
                            </div>
                        </div>  
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .hover-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important;
    }
    
    .badge {
        font-weight: 500;
    }
</style>

@endsection 