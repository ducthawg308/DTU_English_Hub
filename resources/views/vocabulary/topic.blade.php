@extends('layouts.app')

@section('content')
    <div class="container px-4 my-5 px-lg-5" style="min-height: 80vh;">
        <div class="card shadow border-0 mb-4 mt-4">
            <div class="card-body px-5">
                @if ($isCustoms)
                    <h3 class="card-title text-primary fw-bold">Học Từ Vựng Tự Custom</h3>
                    <p class="text-success mb-2">Tạo danh sách từ vựng riêng của bạn và học theo cách của bạn.</p>
                @else
                    <h3 class="card-title text-primary fw-bold">Học từ vựng của hệ thống</h3>
                    <p class="text-success mb-2">Khám phá các từ vựng được hệ thống cung cấp và học tập theo cách hiệu quả nhất.</p>
                @endif
            </div>
        </div>
        
        <div class="list-group">
            @foreach ($topics as $topic)
                <div class="list-group-item d-flex justify-content-between align-items-center border rounded mb-2 shadow-sm">
                    <a href="{{ route('default.vocabulary', $topic->id) }}" class="text-decoration-none text-dark fw-bold">{{ $topic->name }}</a>
                    <div>
                        <a href="{{ route('review.vocabulary', $topic->id) }}" class="btn btn-primary btn-sm">Ôn tập lại</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
