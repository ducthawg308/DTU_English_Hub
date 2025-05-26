@extends('layouts.app')

@section('content')
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<div class="min-vh-100 bg-gradient-to-br from-blue-50 to-indigo-100 py-4 py-md-6">
    <div class="container px-3 px-md-4">
        <!-- Header Section -->
        <div class="text-center mb-8 mb-md-10">
            <h1 class="display-5 fw-bold text-gray-800 mb-3">
                Luyện kỹ năng Speaking
            </h1>
            <p class="lead text-gray-600 max-w-xl mb-5">
                Cải thiện kỹ năng Speaking của bạn với công nghệ AI tiên tiến
            </p>
        </div>

        <!-- Main Features Grid -->
        <div class="row row-cols-1 row-cols-md-2 g-4 g-md-6 max-w-5xl mx-auto">
            <!-- VSTEP Speaking Practice Card -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm overflow-hidden hover-shadow">
                    <div class="card-header bg-gradient-to-r from-blue-600 to-blue-700 border-0 p-4 text-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle d-inline-block mb-3">
                            <img src="img/speaking.png" alt="Icon IPA" width="80" height="40" />
                        </div>
                        <h2 class="card-title h5 fw-bold text-black mb-2">
                            Luyện Speaking VSTEP
                        </h2>
                        <p class="text-blue-100 small">
                            Nâng cao kỹ năng nói với chuẩn VSTEP
                        </p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <ul class="list-unstyled mb-4">
                            <li class="d-flex align-items-start mb-3">
                                <span class="text-blue-600 me-2">✔</span>
                                <div>
                                    <h4 class="fw-semibold text-gray-800 small">Phỏng vấn thực tế</h4>
                                    <p class="text-gray-600 small">Luyện tập với các câu hỏi VSTEP chuẩn</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="text-blue-600 me-2">✔</span>
                                <div>
                                    <h4 class="fw-semibold text-gray-800 small">Phân tích AI</h4>
                                    <p class="text-gray-600 small">Đánh giá phát âm, ngữ pháp, lưu loát</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <span class="text-blue-600 me-2">✔</span>
                                <div>
                                    <h4 class="fw-semibold text-gray-800 small">Phản hồi tức thì</h4>
                                    <p class="text-gray-600 small">Nhận đánh giá chi tiết ngay sau bài</p>
                                </div>
                            </li>
                        </ul>
                        <a href="{{ route('pronounce.ai') }}" class="btn btn-primary w-100 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white fw-semibold py-2 rounded-lg shadow hover-scale" role="button" aria-label="Bắt đầu luyện Speaking VSTEP">
                            Bắt đầu luyện Speaking
                        </a>
                    </div>
                </div>
            </div>

            <!-- IPA Pronunciation Practice Card -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm overflow-hidden hover-shadow">
                    <div class="card-header bg-gradient-to-r from-purple border-0 p-4 text-center" style="background: linear-gradient(to right, #f97316, #ef4444);">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle d-inline-block mb-3">
                            <img src="img/ipa.png" alt="Icon IPA" width="80" height="40" />
                        </div>
                        <h2 class="card-title h5 fw-bold text-white mb-2">
                            Luyện phát âm IPA
                        </h2>
                        <p class="text-white small">
                            Thành thạo bảng phiên âm quốc tế
                        </p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <ul class="list-unstyled mb-4">
                            <li class="d-flex align-items-start mb-3">
                                <span class="text-orange-600 me-2">✔</span>
                                <div>
                                    <h4 class="fw-semibold text-gray-800 small">Bảng IPA chuẩn</h4>
                                    <p class="text-gray-600 small">Học 44 âm tiết tiếng Anh chuẩn</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="text-orange-600 me-2">✔</span>
                                <div>
                                    <h4 class="fw-semibold text-gray-800 small">Phát âm chuẩn</h4>
                                    <p class="text-gray-600 small">Nghe và luyện tập từng âm</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start">
                                <span class="text-orange-600 me-2">✔</span>
                                <div>
                                    <h4 class="fw-semibold text-gray-800 small">Kiểm tra phát âm</h4>
                                    <p class="text-gray-600 small">AI đánh giá độ chính xác</p>
                                </div>
                            </li>
                        </ul>
                        <a href="{{ route('pronounce.ipa') }}" class="btn btn-primary w-100 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white fw-semibold py-2 rounded-lg shadow hover-scale" role="button" aria-label="Bắt đầu học bảng phiên âm IPA">
                            Học bảng phiên âm IPA
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .hover-shadow {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Hover scale effect for buttons */
    .hover-scale {
        transition: transform 0.2s ease;
    }
    .hover-scale:hover {
        transform: scale(1.02);
    }

    /* Responsive typography */
    @media (max-width: 576px) {
        .display-5 {
            font-size: 1.75rem;
        }
        .lead {
            font-size: 1rem;
        }
        .card-title {
            font-size: 1.1rem;
        }
        .card-body {
            padding: 1.25rem;
        }
    }

    /* Accessibility: High contrast colors */
    .text-gray-800 {
        color: #1f2937;
    }
    .text-gray-600 {
        color: #4b5563;
    }
</style>
@endsection