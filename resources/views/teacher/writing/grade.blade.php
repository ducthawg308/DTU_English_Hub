@extends('layouts.teacher')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-2">Chấm điểm bài viết</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('teacher') }}">DTU English Hub</a></li>
        <li class="breadcrumb-item"><a href="{{ route('teacher.writing') }}">Quản lý bài viết</a></li>
        <li class="breadcrumb-item active">Chấm điểm</li>
    </ol>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Thông tin bài làm</h5>
                </div>
                <div class="card-body">
                    <p><strong>Học viên:</strong> {{ $submission->student_name }}</p>
                    <p><strong>Bài thi:</strong> {{ $submission->exam_title }}</p>
                    <p><strong>Đề bài:</strong></p>
                    <div class="alert alert-info">
                        {{ $submission->writing_prompt }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Đánh giá của AI</h5>
                </div>
                <div class="card-body">
                    <p><strong>Điểm số AI:</strong> {{ $submission->ai_score }}</p>
                    <p><strong>Nhận xét của AI:</strong></p>
                    <div class="alert alert-secondary">
                        <pre class="mb-0">{{ $submission->ai_feedback }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Bài làm của học viên</h5>
        </div>
        <div class="card-body">
            <div class="border p-3 mb-4 bg-light">
                {!! nl2br(e($submission->response_text)) !!}
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Đánh giá của giáo viên</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('teacher.writing.submit-grade', $submission->response_id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="teacher_score" class="form-label">Điểm số (0-10):</label>
                    <input type="number" class="form-control" id="teacher_score" name="teacher_score" min="0" max="9" step="0.1" required>
                    @error('teacher_score')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="teacher_feedback" class="form-label">Nhận xét:</label>
                    <textarea class="form-control" id="teacher_feedback" name="teacher_feedback" rows="5" required></textarea>
                    @error('teacher_feedback')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="scoring-guide mb-4">
                    <h6>Hướng dẫn chấm điểm:</h6>
                    <ul>
                        <li><strong>8.0 - 10.0:</strong> Xuất sắc - Nội dung phong phú, cấu trúc rất mạch lạc và ít lỗi ngữ pháp</li>
                        <li><strong>6.5 - 7.5:</strong> Tốt - Nội dung đầy đủ, cấu trúc mạch lạc và một số lỗi ngữ pháp nhỏ</li>
                        <li><strong>5.0 - 6.0:</strong> Khá - Nội dung đủ, cấu trúc hợp lý và một số lỗi ngữ pháp</li>
                        <li><strong>4.0 - 4.5:</strong> Trung bình - Nội dung còn thiếu, cấu trúc chưa mạch lạc và nhiều lỗi ngữ pháp</li>
                        <li><strong>< 4.0:</strong> Yếu - Nội dung rất thiếu, cấu trúc không mạch lạc và quá nhiều lỗi ngữ pháp</li>
                    </ul>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('teacher.writing') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu điểm số</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection