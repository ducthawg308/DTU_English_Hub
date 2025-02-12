@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="text-center mb-4 text-primary">Kết quả bài kiểm tra</h2>
        <div class="text-center">
            <p class="fs-4 fw-bold">Số câu trả lời đúng: <span class="text-success">{{ $result->total_correct }}</span></p>
            <p class="fs-4 fw-bold">Điểm số: <span class="text-danger">{{ $result->score }}</span></p>
        </div>
        @foreach ($result->answers as $answer)
            <p class="mt-4"><strong>Câu {{ $loop->iteration }}:</strong> {{ $answer->question->question }}</p>
            <p>Đáp án đã chọn: {{ $answer->selected_answer }}</p>
            <p style="color: {{ $answer->is_correct ? 'green' : 'red' }}">
                {{ $answer->is_correct ? 'Đúng' : 'Sai' }}
            </p>
        @endforeach
    </div>
@endsection
