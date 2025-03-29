@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-3">{{ $document->title }}</h3>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Mã môn:</strong> {{ $document->subject }}</li>
                <li class="list-group-item"><strong>Người đăng:</strong> {{ $document->user->name ?? 'Ẩn danh' }}</li>
                <li class="list-group-item"><strong>Ngày đăng:</strong> {{ $document->created_at->format('d/m/Y') }}</li>
            </ul>

            <div class="mb-4">
                <h5 class="mb-2"><strong>Mô tả:</strong></h5>
                <p class="text-muted">{{ $document->description }}</p>
            </div>

            @php
                $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
            @endphp

            {{-- Preview tài liệu --}}
            <div class="mb-4">
                @if($extension === 'pdf')
                    <iframe src="{{ asset('storage/' . $document->file_path) }}" width="100%" height="600px" class="border rounded"></iframe>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-file-earmark-excel"></i>
                        Không thể xem trước. Vui lòng tải về để xem chi tiết.
                    </div>
                @endif
            </div>

            {{-- Nút tải --}}
            <a href="{{ route('document.download', $document->id) }}" class="btn btn-outline-primary" download>
                <i class="fa-solid fa-download"></i> Tải tài liệu
            </a>
        </div>
    </div>
</div>
@endsection
