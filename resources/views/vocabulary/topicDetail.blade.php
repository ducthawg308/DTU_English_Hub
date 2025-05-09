@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-primary text-center mb-5">📚 Danh Sách Chủ Đề Từ Vựng</h2>

    @if ($topics->isEmpty())
        <div class="alert alert-info text-center">
            Hiện chưa có chủ đề nào sẵn sàng để học.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($topics as $topic)
                <div class="col">
                    <div class="card shadow-sm border-0 h-100 rounded-4 hover-shadow transition-all">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold text-dark mb-2">{{ $topic->name }}</h5>
                            <div class="d-flex justify-content-between gap-2 mt-auto">
                                <a href="{{ route('default.vocabulary', $topic->id) }}" class="btn btn-primary flex-grow-1 rounded-pill">Học từ vựng</a>
                                <a href="{{ route('review.vocabulary', $topic->id) }}" class="btn btn-outline-secondary flex-grow-1 rounded-pill">Ôn tập lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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
