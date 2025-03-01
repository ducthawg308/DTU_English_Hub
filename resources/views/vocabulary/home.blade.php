@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="my-5">
            <div class="position-relative">
                <div class="max-w-1200px mx-4 md:mx-8 xl:mx-auto">
                    <div class="leading-6 d-flex justify-content-center gap-8 align-items-center mt-8 flex-column-reverse lg:flex-row mb-3 lg:mb-6">
                        <img src="Star" class="position-absolute top-12 left-27p d-none lg:block" alt="Star" />
                        <div class="d-flex flex-column align-items-center">
                            <h1 class="text-lg sm:text-2xl lg:text-40px text-title text-center lg:text-start fw-bold mb-4">
                                English Vocabulary
                            </h1>
                            <p class="text-sm sm:text-base lg:text-lg font-text-regular text-sub-title mb-0 text-gray-600">
                                Hãy bắt đầu hành trình học từ vựng tiếng Anh được phân loại trên Daily Dictation
                            </p>
                        </div>
                        <img src="Star" class="position-absolute top-0 right-30p d-none lg:block" alt="Start" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow border-light rounded">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Học Từ Vựng Của Hệ Thống</h5>
                        <p class="card-text">Khám phá các từ vựng được hệ thống cung cấp và học tập theo cách hiệu quả nhất.</p>
                        <a href="{{ route('topic.vocabulary') }}" class="btn btn-primary">Bắt đầu học</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow border-light rounded">
                    <div class="card-body">
                        <h5 class="card-title text-success">Học Từ Vựng Tự Custom</h5>
                        <p class="card-text">Tạo danh sách từ vựng riêng của bạn và học theo cách của bạn.</p>
                        <a href="{{ route('custom.vocabulary') }}" class="btn btn-success">Tạo danh sách từ vựng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection