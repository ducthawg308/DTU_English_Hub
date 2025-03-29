@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <h2 class="text-primary fw-bold mb-3">Kết quả bài kiểm tra</h2>
            <p class="fs-4">✅ <strong>Số câu trả lời đúng:</strong> <span class="text-success">{{ $result->total_correct }}</span></p>
            <p class="fs-4">🎯 <strong>Điểm số:</strong>
                <span class="{{ $result->score >= 5 ? 'text-success' : 'text-danger' }}">
                    {{ $result->score }}
                </span>
            </p>
        </div>
    </div>

    @foreach ($result->answers as $answer)
        <div class="card mb-3 shadow-sm border-{{ $answer->is_correct ? 'success' : 'danger' }}">
            <div class="card-body">
                <p class="mb-2"><strong>Câu {{ $loop->iteration }}:</strong> {{ $answer->question->question }}</p>
                <p class="mb-1">📌 <strong>Đáp án đã chọn:</strong> {{ $answer->selected_answer }}</p>
                <p class="fw-bold" style="color: {{ $answer->is_correct ? 'green' : 'red' }}">
                    {{ $answer->is_correct ? '✔️ Đúng' : '❌ Sai' }}
                </p>
            </div>
        </div>
    @endforeach
</div>
@endsection
