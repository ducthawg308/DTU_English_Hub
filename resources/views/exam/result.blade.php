@extends('layouts.exam')

@section('content')
<style>
    .results-container {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }
    .skill-card {
        background-color: #ffffff;
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .skill-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .skill-title {
        font-size: 1.5rem;
        color: #2c5dc9;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .score-text {
        font-size: 1.2rem;
        color: #333333;
    }
    .prompt-section {
        margin-top: 1rem;
    }
    .prompt-text {
        color: #555555;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    .user-answer {
        background-color: #f1f3f9;
        color: #333;
        padding: 1rem;
        border-radius: 10px;
        font-size: 0.95rem;
        border: 1px solid #d9e1f2;
    }
    .audio-player {
        width: 100%;
        margin-top: 0.5rem;
    }
    .btn-back {
        background-color: #3366cc;
        border: none;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        border-radius: 25px;
        transition: background-color 0.3s ease;
    }
    .btn-back:hover {
        background-color: #2851a3;
    }
    .btn-toggle-feedback {
        background-color: #28a745;
        border: none;
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
        border-radius: 20px;
        color: #ffffff;
        transition: background-color 0.3s ease;
        margin-top: 1rem;
    }
    .btn-toggle-feedback:hover {
        background-color: #218838;
    }
    .feedback-details {
        display: none;
        margin-top: 1.5rem;
    }
    .feedback-details.show {
        display: block;
    }
    .evaluation-details {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #e4e9f2;
    }
    .evaluation-details h4 {
        font-size: 1.3rem;
        color: #2c5dc9;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }
    .score-list {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    .score-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        background-color: #f1f3f9;
        border-radius: 8px;
        color: #333333;
        font-size: 1rem;
        transition: background-color 0.2s ease;
        border: 1px solid #d9e1f2;
    }
    .score-list li:hover {
        background-color: #e4e9f2;
    }
    .score-list li.total {
        background-color: #3366cc;
        font-weight: bold;
        color: #ffffff;
        border: none;
    }
    .feedback-card {
        border: none;
        border-radius: 10px;
        margin-bottom: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .feedback-card-header {
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
    }
    .feedback-card-body {
        padding: 1.25rem;
        background-color: #ffffff;
        color: #333333;
        font-size: 0.95rem;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-top: none;
    }
    .feedback-card ul {
        padding-left: 1.25rem;
        margin-bottom: 0;
    }
    .feedback-card ul li {
        margin-bottom: 0.5rem;
    }
    .corrected-text {
        background-color: #f1f3f9;
        color: #333;
        padding: 1.5rem;
        border-radius: 10px;
        font-size: 0.95rem;
        border: 1px solid #d9e1f2;
    }
    .error-table th, .error-table td {
        padding: 0.75rem;
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .error-table th {
        background-color: #3366cc;
        color: #ffffff;
        font-weight: 600;
    }
    .error-table td {
        background-color: #ffffff;
        color: #333333;
        border: 1px solid #dee2e6;
    }
    @media (max-width: 576px) {
        .skill-title {
            font-size: 1.25rem;
        }
        .score-text {
            font-size: 1rem;
        }
        .results-container {
            padding: 1rem 0;
        }
        .skill-card {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .evaluation-details {
            padding: 1rem;
        }
        .score-list li {
            font-size: 0.9rem;
            padding: 0.5rem;
        }
        .feedback-card-header {
            font-size: 0.9rem;
        }
        .feedback-card-body {
            font-size: 0.85rem;
        }
    }
</style>

<div class="results-container">
    <div class="container">
        <h1 class="text-center mb-5 text-dark" style="font-size: 2.5rem;">Kết quả bài thi: {{ $exam->title }}</h1>

        @if(!empty($results['listening']['details']))
        <div class="skill-card">
            <h2 class="skill-title">Listening</h2>
            <p class="score-text">
                Tổng điểm: {{ number_format($results['listening']['score'], 2) }} / 10
            </p>
        </div>
        @endif

        @if(!empty($results['reading']['details']))
        <div class="skill-card">
            <h2 class="skill-title">Reading</h2>
            <p class="score-text">
                Tổng điểm: {{ number_format($results['reading']['score'], 2) }} / 10
            </p>
        </div>
        @endif

        <!-- Writing Results -->
        @if(!empty($results['writing']))
        <div class="skill-card">
            <h2 class="skill-title">Writing</h2>
            @if(isset($results['writing']['score']))
            <p class="score-text">
                Tổng điểm: {{ number_format($results['writing']['score'], 2) }} / 10
            </p>
            @endif
            
            @foreach($results['writing'] as $index => $writing)
                @if(is_array($writing) && isset($writing['prompt_text']))
                <div class="prompt-section">
                    <p class="prompt-text"><strong>Đề bài {{ $index + 1 }}:</strong> {!! $writing['prompt_text'] !!}</p>
                    
                    <div class="user-answer mb-3">
                        {{ $writing['user_answer'] ?: 'Chưa nộp bài' }}
                    </div>
                    
                    @if(isset($writing['ai_score']))
                    <p class="score-text">
                        Điểm: {{ number_format($writing['ai_score']['total'], 1) }}/10
                    </p>
                    <button class="btn-toggle-feedback" onclick="toggleFeedback('feedback-{{ $index }}')">Nhận xét của AI</button>
                    
                    <div class="feedback-details" id="feedback-{{ $index }}">
                        <div class="evaluation-details mt-3">
                            <h4>Đánh giá chi tiết</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="score-list">
                                        <li>
                                            <span>Nội dung</span>
                                            <span>{{ number_format($writing['ai_score']['content'], 1) }}/10</span>
                                        </li>
                                        <li>
                                            <span>Ngữ pháp</span>
                                            <span>{{ number_format($writing['ai_score']['grammar'], 1) }}/10</span>
                                        </li>
                                        <li>
                                            <span>Từ vựng</span>
                                            <span>{{ number_format($writing['ai_score']['vocabulary'], 1) }}/10</span>
                                        </li>
                                        <li>
                                            <span>Cấu trúc</span>
                                            <span>{{ number_format($writing['ai_score']['structure'], 1) }}/10</span>
                                        </li>
                                        <li class="total">
                                            <span>Tổng điểm</span>
                                            <span>{{ number_format($writing['ai_score']['total'], 1) }}/10</span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="col-md-6">
                                    @if(isset($writing['ai_feedback']))
                                    <div class="feedback-card">
                                        <div class="feedback-card-header" style="background-color: #5878c4;">Nhận xét chung</div>
                                        <div class="feedback-card-body">
                                            <p>{{ $writing['ai_feedback']['general'] }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feedback-card">
                                        <div class="feedback-card-header" style="background-color: #28a745;">Điểm mạnh</div>
                                        <div class="feedback-card-body">
                                            <ul>
                                                @foreach($writing['ai_feedback']['strengths'] as $strength)
                                                    <li>{{ $strength }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="feedback-card">
                                        <div class="feedback-card-header" style="background-color: #dc3545;">Điểm yếu</div>
                                        <div class="feedback-card-body">
                                            <ul>
                                                @foreach($writing['ai_feedback']['weaknesses'] as $weakness)
                                                    <li>{{ $weakness }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="feedback-card">
                                        <div class="feedback-card-header" style="background-color: #17a2b8;">Gợi ý cải thiện</div>
                                        <div class="feedback-card-body">
                                            <p>{{ $writing['ai_feedback']['suggestions'] }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if(isset($writing['corrections']) && isset($writing['corrections']['corrected_text']))
                            <div class="mt-4">
                                <h4 class="text-dark mb-2">Bài viết đã được chỉnh sửa</h4>
                                <div class="corrected-text">
                                    {!! $writing['corrections']['corrected_text'] !!}
                                </div>
                                
                                @if(isset($writing['corrections']['detailed_errors']) && count($writing['corrections']['detailed_errors']) > 0)
                                <div class="mt-3">
                                    <h5 class="text-dark mb-2">Chi tiết lỗi</h5>
                                    <div class="table-responsive">
                                        <table class="table error-table">
                                            <thead>
                                                <tr>
                                                    <th>Lỗi</th>
                                                    <th>Sửa thành</th>
                                                    <th>Giải thích</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($writing['corrections']['detailed_errors'] as $error)
                                                <tr>
                                                    <td>{{ $error['error'] }}</td>
                                                    <td>{{ $error['correction'] }}</td>
                                                    <td>{{ $error['explanation'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                <hr class="my-4" style="border-color: #dee2e6;">
                @endif
            @endforeach
        </div>
        @endif

        <!-- Speaking Results -->
        @if(!empty($results['speaking']))
        <div class="skill-card">
            <h2 class="skill-title">Speaking</h2>
            @foreach($results['speaking'] as $index => $speaking)
            <div class="prompt-section">
                <p class="prompt-text"><strong>Đề bài {{ $index + 1 }}:</strong> {!! $speaking['prompt_text'] !!}</p>
                @if($speaking['user_answer'] === 'Audio submitted' && !empty($speaking['audio_data']))
                <audio controls class="audio-player" id="audio-player-{{ $index }}">
                    <source src="{{ $speaking['audio_data'] }}" type="audio/mpeg">
                    Trình duyệt của bạn không hỗ trợ phát âm thanh.
                </audio>
                <script>
                    document.getElementById('audio-player-{{ $index }}').addEventListener('error', function() {
                        this.insertAdjacentHTML('afterend', '<p class="text-warning mt-2">Không thể tải file âm thanh. Vui lòng tải lại trang hoặc liên hệ hỗ trợ.</p>');
                    });
                </script>
                @else
                <p class="text-secondary">Không có bản ghi âm.</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('home.exam') }}" class="btn btn-back text-white">Quay lại danh sách bài thi</a>
        </div>
    </div>
</div>

<script>
    function toggleFeedback(feedbackId) {
        const feedbackElement = document.getElementById(feedbackId);
        feedbackElement.classList.toggle('show');
    }
</script>
@endsection