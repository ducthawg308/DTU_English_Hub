@extends('layouts.teacher')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-2">Chấm điểm kết hợp</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('teacher') }}">DTU English Hub</a></li>
        <li class="breadcrumb-item active">Chấm điểm kết hợp</li>
    </ol>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Thông tin học viên</h5>
                </div>
                <div class="card-body">
                    <p><strong>Học viên:</strong> {{ $studentInfo->student_name }}</p>
                    <p><strong>Bài thi:</strong> {{ $studentInfo->exam_title }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Tổng quan tiến độ</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($writingSubmissions->count() > 0)
                            <div class="col-md-6">
                                <p><strong>Writing:</strong> 
                                    @if($writingSubmissions->whereNotNull('teacher_score')->count() == $writingSubmissions->count())
                                        <span class="badge bg-success">Đã chấm</span>
                                    @else
                                        <span class="badge bg-warning">Chưa chấm</span>
                                    @endif
                                </p>
                            </div>
                        @endif
                        @if($speakingSubmissions->count() > 0)
                            <div class="col-md-6">
                                <p><strong>Speaking:</strong> 
                                    @if($speakingSubmissions->whereNotNull('teacher_score')->count() == $speakingSubmissions->count())
                                        <span class="badge bg-success">Đã chấm</span>
                                    @else
                                        <span class="badge bg-warning">Chưa chấm</span>
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Start -->
    <form action="{{ route('teacher.combined.submit-grade', ['user_id' => $studentInfo->user_id, 'submission_id' => $studentInfo->submission_id]) }}" method="POST">
        @csrf

        <!-- Writing Sections -->
        @foreach($writingSubmissions as $index => $writingSubmission)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Bài viết {{ $index + 1 }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <h6>Đề bài:</h6>
                        <div class="alert alert-info">
                            {!! $writingSubmission->writing_prompt !!}
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h6>Bài làm của học viên:</h6>
                        <div class="border p-3 mb-4 bg-light">
                            {!! nl2br(e($writingSubmission->response_text)) !!}
                        </div>
                    </div>
                </div>
                
                @if($writingSubmission->ai_score)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6>Đánh giá của AI:</h6>
                        <p><strong>Điểm số AI:</strong> {{ $writingSubmission->ai_score }}</p>
                        <div class="alert alert-secondary">
                            <pre class="mb-0">{{ $writingSubmission->ai_feedback }}</pre>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="row">
                    <div class="col-12">
                        <h6>Đánh giá của giáo viên:</h6>
                        <div class="writing-grading">
                            <input type="hidden" name="writing_response_ids[]" value="{{ $writingSubmission->response_id }}">
                            <div class="mb-3">
                                <label for="writing_teacher_score_{{ $writingSubmission->response_id }}" class="form-label">Điểm số (0-10):</label>
                                <input type="number" class="form-control" id="writing_teacher_score_{{ $writingSubmission->response_id }}" name="writing_teacher_scores[]" min="0" max="9" step="0.1" value="{{ $writingSubmission->teacher_score ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="writing_teacher_feedback_{{ $writingSubmission->response_id }}" class="form-label">Nhận xét:</label>
                                <textarea class="form-control" id="writing_teacher_feedback_{{ $writingSubmission->response_id }}" name="writing_teacher_feedbacks[]" rows="4" required>{{ $writingSubmission->teacher_feedback ?? '' }}</textarea>
                            </div>
                            <div class="scoring-guide mb-3">
                                <h6>Hướng dẫn chấm điểm:</h6>
                                <ul>
                                    <li><strong>8.0 - 10.0:</strong> Xuất sắc - Nội dung phong phú, cấu trúc rất mạch lạc và ít lỗi ngữ pháp</li>
                                    <li><strong>6.5 - 7.5:</strong> Tốt - Nội dung đầy đủ, cấu trúc mạch lạc và một số lỗi ngữ pháp nhỏ</li>
                                    <li><strong>5.0 - 6.0:</strong> Khá - Nội dung đủ, cấu trúc hợp lý và một số lỗi ngữ pháp</li>
                                    <li><strong>4.0 - 4.5:</strong> Trung bình - Nội dung còn thiếu, cấu trúc chưa mạch lạc và nhiều lỗi ngữ pháp</li>
                                    <li><strong>< 4.0:</strong> Yếu - Nội dung rất thiếu, cấu trúc không mạch lạc và quá nhiều lỗi ngữ pháp</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Speaking Sections -->
        @foreach($speakingSubmissions as $index => $speakingSubmission)
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Bài nói {{ $index + 1 }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <h6>Đề bài:</h6>
                        <div class="alert alert-info">
                            {!! $speakingSubmission->speaking_prompt !!}
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h6>Bài làm của học viên:</h6>
                        <div class="border p-3 mb-4 bg-light">
                            <audio controls style="width: 100%;">
                                <source src="{{ $speakingSubmission->audio_url }}" type="audio/mp3">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>
                
                @if($speakingSubmission->ai_score)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6>Đánh giá của AI:</h6>
                        <p><strong>Điểm số AI:</strong> {{ $speakingSubmission->ai_score }}</p>
                        <div class="alert alert-secondary">
                            <pre class="mb-0">{{ $speakingSubmission->ai_feedback }}</pre>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="row">
                    <div class="col-12">
                        <h6>Đánh giá của giáo viên:</h6>
                        <div class="speaking-grading">
                            <input type="hidden" name="speaking_response_ids[]" value="{{ $speakingSubmission->response_id }}">
                            <div class="mb-3">
                                <label for="speaking_teacher_score_{{ $speakingSubmission->response_id }}" class="form-label">Điểm số (0-10):</label>
                                <input type="number" class="form-control" id="speaking_teacher_score_{{ $speakingSubmission->response_id }}" name="speaking_teacher_scores[]" min="0" max="9" step="0.1" value="{{ $speakingSubmission->teacher_score ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="speaking_teacher_feedback_{{ $speakingSubmission->response_id }}" class="form-label">Nhận xét:</label>
                                <textarea class="form-control" id="speaking_teacher_feedback_{{ $speakingSubmission->response_id }}" name="speaking_teacher_feedbacks[]" rows="4" required>{{ $speakingSubmission->teacher_feedback ?? '' }}</textarea>
                            </div>
                            <div class="scoring-guide mb-3">
                                <h6>Hướng dẫn chấm điểm:</h6>
                                <ul>
                                    <li><strong>8.0 - 10.0:</strong> Xuất sắc - Phát âm rõ ràng, ngữ điệu tự nhiên và nội dung đầy đủ</li>
                                    <li><strong>6.5 - 7.5:</strong> Tốt - Phát âm tốt, ngữ điệu ổn và nội dung khá đầy đủ</li>
                                    <li><strong>5.0 - 6.0:</strong> Khá - Phát âm trung bình, ngữ điệu chưa tự nhiên và nội dung đủ dùng</li>
                                    <li><strong>4.0 - 4.5:</strong> Trung bình - Phát âm chưa rõ, ngữ điệu chưa ổn và nội dung còn thiếu</li>
                                    <li><strong>< 4.0:</strong> Yếu - Phát âm kém, ngữ điệu không tự nhiên và nội dung rất thiếu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Submit Button -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('teacher.combined') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu tất cả điểm số</button>
                </div>
            </div>
        </div>
    </form>
    <!-- Form End -->
</div>
@endsection
