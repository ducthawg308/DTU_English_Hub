@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold">Chọn Box Từ Vựng</h2>
                <p class="text-muted">Lựa chọn box phù hợp với mức độ ghi nhớ của bạn</p>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            <!-- Box 1: Dễ Nhớ -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 box-card cursor-pointer" data-box="1">
                    <div class="card-body text-center p-4">
                        <div class="box-icon bg-success-subtle rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                        </div>
                        <h3 class="card-title fw-bold">Box 1: Dễ Nhớ</h3>
                        <p class="card-text text-muted">
                            Những từ vựng bạn đã ghi nhớ tốt và ít cần ôn tập lại.
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="bi bi-clock me-1"></i> Ôn tập sau 7 ngày
                            </span>
                            <span class="badge bg-light text-dark px-3 py-2">
                                <span id="box1-count">{{$box1}}</span> từ vựng
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3">
                        <a href="{{ route('learnBox', 1) }}" class="btn btn-success w-100">Ôn tập Box 1</a>
                    </div>
                </div>
            </div>

            <!-- Box 2: Dễ Quên -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 box-card cursor-pointer" data-box="2">
                    <div class="card-body text-center p-4">
                        <div class="box-icon bg-warning-subtle rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                        </div>
                        <h3 class="card-title fw-bold">Box 2: Dễ Quên</h3>
                        <p class="card-text text-muted">
                            Những từ vựng bạn đôi khi còn nhầm lẫn và cần ôn tập thường xuyên.
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                <i class="bi bi-clock me-1"></i> Ôn tập sau 3 ngày
                            </span>
                            <span class="badge bg-light text-dark px-3 py-2">
                                <span id="box2-count">{{$box2}}</span> từ vựng
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3">
                        <a href="{{ route('learnBox', 2) }}" class="btn btn-warning w-100">Ôn tập Box 2</a>
                    </div>
                </div>
            </div>

            <!-- Box 3: Rất Dễ Quên -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 box-card cursor-pointer" data-box="3">
                    <div class="card-body text-center p-4">
                        <div class="box-icon bg-danger-subtle rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-x-circle-fill text-danger fs-1"></i>
                        </div>
                        <h3 class="card-title fw-bold">Box 3: Rất Dễ Quên</h3>
                        <p class="card-text text-muted">
                            Những từ vựng khó mà bạn cần tập trung ôn tập nhiều lần.
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                <i class="bi bi-clock me-1"></i> Ôn tập hàng ngày
                            </span>
                            <span class="badge bg-light text-dark px-3 py-2">
                                <span id="box3-count">{{$box3}}</span> từ vựng
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3">
                        <a href="{{ route('learnBox', 3) }}" class="btn btn-danger w-100">Ôn tập Box 3</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .box-icon {
            width: 80px;
            height: 80px;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .box-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .box-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
    </style>
@endsection