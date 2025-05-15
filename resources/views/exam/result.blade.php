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
            @foreach($results['writing'] as $index => $writing)
            <div class="prompt-section">
                <p class="prompt-text"><strong>Đề bài {{ $index + 1 }}:</strong> {!! $writing['prompt_text'] !!}</p>
                <div class="user-answer">
                    {{ $writing['user_answer'] ?: 'Chưa nộp bài' }}
                </div>
            </div>
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
                <audio controls class="audio-player">
                    <source src="{{ $speaking['audio_data'] }}" type="audio/mpeg">
                    Trình duyệt của bạn không hỗ trợ phát âm thanh.
                </audio>
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
@endsection