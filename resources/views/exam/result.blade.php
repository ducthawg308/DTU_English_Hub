@extends('layouts.app')

@section('content')
<style>
    .results-container {
        background-color: #102342;
        min-height: 100vh;
        padding: 2rem 0;
    }
    .skill-card {
        background-color: #1a2c54;
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .skill-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }
    .skill-title {
        font-size: 1.5rem;
        color: #f8c307;
        margin-bottom: 1rem;
    }
    .score-text {
        font-size: 1.2rem;
        color: #ffffff;
    }
    .prompt-section {
        margin-top: 1rem;
    }
    .prompt-text {
        color: #d3d3d3;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    .user-answer {
        background-color: #ffffff;
        color: #333;
        padding: 1rem;
        border-radius: 10px;
        font-size: 0.95rem;
    }
    .audio-player {
        width: 100%;
        margin-top: 0.5rem;
    }
    .btn-back {
        background-color: #007bff;
        border: none;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        border-radius: 25px;
        transition: background-color 0.3s ease;
    }
    .btn-back:hover {
        background-color: #0056b3;
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
        background-color: #1a2c54;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    .evaluation-details h4 {
        font-size: 1.3rem;
        color: #f8c307;
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
        background-color: #2a3b6a;
        border-radius: 8px;
        color: #ffffff;
        font-size: 1rem;
        transition: background-color 0.2s ease;
    }
    .score-list li:hover {
        background-color: #3a4b8a;
    }
    .score-list li.total {
        background-color: #007bff;
        font-weight: bold;
    }
    .feedback-card {
        border: none;
        border-radius: 10px;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .feedback-card-header {
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
    }
    .feedback-card-body {
        padding: 1.25rem;
        background-color: #2a3b6a;
        color: #d3d3d3;
        font-size: 0.95rem;
    }
    .feedback-card ul {
        padding-left: 1.25rem;
        margin-bottom: 0;
    }
    .feedback-card ul li {
        margin-bottom: 0.5rem;
    }
    .corrected-text {
        background-color: #ffffff;
        color: #333;
        padding: 1.5rem;
        border-radius: 10px;
        font-size: 0.95rem;
    }
    .error-table th, .error-table td {
        padding: 0.75rem;
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .error-table th {
        background-color: #2a3b6a;
        color: #f8c307;
        font-weight: 600;
    }
    .error-table td {
        background-color: #1a2c54;
        color: #ffffff;
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
        <h1 class="text-center mb-5 text-white" style="font-size: 2.5rem;">Kết quả bài thi: {{ $exam->title }}</h1>

        <!-- Listening Results -->
        @if(!empty($results['listening']['details']))
        <div class="skill-card">
            <h2 class="skill-title">Listening</h2>
            <p class="score-text">
                Tổng điểm: {{ number_format($results['listening']['score'], 2) }} / {{ number_format($results['listening']['total_score_possible'], 2) }}
            </p>
        </div>
        @endif

        <!-- Reading Results -->
        @if(!empty($results['reading']['details']))
        <div class="skill-card">
            <h2 class="skill-title">Reading</h2>
            <p class="score-text">
                Tổng điểm: {{ number_format($results['reading']['score'], 2) }} / {{ number_format($results['reading']['total_score_possible'], 2) }}
            </p>
        </div>
        @endif

        <!-- Writing Results -->
        @if(!empty($results['writing']))
        <div class="skill-card">
            <h2 class="skill-title">Writing</h2>
            @if(isset($results['writing']['score']))
            <p class="score-text">
                Tổng điểm: {{ number_format($results['writing']['score'], 2) }} / {{ number_format($results['writing']['total_score_possible'], 2) }}
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
                        Tổng điểm: {{ number_format($writing['ai_score']['total'], 1) }}/10
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
                                    <div class="feedback-card" style="background-color: #2a3b6a;">
                                        <div class="feedback-card-header" style="background-color: #3a4b8a;">Nhận xét chung</div>
                                        <div class="feedback-card-body">
                                            <p>{{ $writing['ai_feedback']['general'] }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="feedback-card" style="background-color: #28a745;">
                                        <div class="feedback-card-header" style="background-color: #218838;">Điểm mạnh</div>
                                        <div class="feedback-card-body">
                                            <ul>
                                                @foreach($writing['ai_feedback']['strengths'] as $strength)
                                                    <li>{{ $strength }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="feedback-card" style="background-color: #dc3545;">
                                        <div class="feedback-card-header" style="background-color: #c82333;">Điểm yếu</div>
                                        <div class="feedback-card-body">
                                            <ul>
                                                @foreach($writing['ai_feedback']['weaknesses'] as $weakness)
                                                    <li>{{ $weakness }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="feedback-card" style="background-color: #17a2b8;">
                                        <div class="feedback-card-header" style="background-color: #138496;">Gợi ý cải thiện</div>
                                        <div class="feedback-card-body">
                                            <p>{{ $writing['ai_feedback']['suggestions'] }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if(isset($writing['corrections']) && isset($writing['corrections']['corrected_text']))
                            <div class="mt-4">
                                <h4 class="text-white mb-2">Bài viết đã được chỉnh sửa</h4>
                                <div class="corrected-text">
                                    {!! $writing['corrections']['corrected_text'] !!}
                                </div>
                                
                                @if(isset($writing['corrections']['detailed_errors']) && count($writing['corrections']['detailed_errors']) > 0)
                                <div class="mt-3">
                                    <h5 class="text-white mb-2">Chi tiết lỗi</h5>
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
                <hr class="border-secondary my-4">
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
                <p class="text-light">Không có bản ghi âm.</p>
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
