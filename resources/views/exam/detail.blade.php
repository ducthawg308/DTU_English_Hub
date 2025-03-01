@extends('layouts.app')

@section('content')
    <div class="container d-flex my-2">
        <!-- Sidebar -->
        <div class="border p-3 me-4" style="width: 250px;">
            <h5 class="text-center fw-bold">Chọn câu hỏi</h5>
            <div class="d-flex flex-wrap">
                @foreach ($questions as $index => $question)
                    @php
                        $answered = session("answers.{$question->id}", false);
                    @endphp
                    <a href="#question-{{ $question->id }}" 
                    id="question-btn-{{ $question->id }}"
                    class="btn btn-sm m-1 {{ $answered ? 'btn-success' : 'btn-light' }}">
                        {{ $loop->iteration }}
                    </a>
                @endforeach
            </div>
        </div>
    
        <!-- Nội dung bài test -->
        <div class="flex-grow-1">
            <h2 class="text-center mb-4 fw-bold display-6 pt-4">{{ $exam->name }}</h2>
            
            <!-- Đồng hồ đếm ngược -->
            <div class="text-center mb-3">
                <h4 class="fw-bold">Thời gian còn lại:</h4>
                <div id="timer" class="display-6 text-danger fw-bold bg-light px-4 py-2 rounded d-inline-block shadow">
                    --:--
                </div>
            </div>
    
            <form action="{{ route('exam.submit', $exam->id) }}" method="POST">
                @csrf
                @foreach ($questions as $index => $question)
                    <p id="question-{{ $question->id }}" class="mt-4"><strong>Câu {{ $loop->iteration }}:</strong> {{ $question->question }}</p>
                    @foreach (['A', 'B', 'C', 'D'] as $option)
                        <label>
                            <input type="radio" name="answers[{{ $question->id }}]" 
                                   value="{{ $option }}" 
                                   onchange="markAnswered({{ $question->id }})"
                                   {{ session("answers.{$question->id}") ? 'checked' : '' }}>
                            {{ $question['option_' . strtolower($option)] }}
                        </label><br>
                    @endforeach
                @endforeach
                <div class="text-center p-4">
                    <button type="submit" class="btn btn-primary px-4">Nộp bài</button>
                </div>
            </form>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let timeLeft = {{ $exam->time }} * 60; // Chuyển phút thành giây
        let timerElement = document.getElementById("timer");
        let form = document.getElementById("exam-form");

        function updateTimer() {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (timeLeft <= 0) {
                alert("Hết thời gian! Bài thi sẽ được nộp.");
                form.submit();
            } else {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }

        updateTimer();
    });

    function markAnswered(questionId) {
        let btn = document.getElementById(`question-btn-${questionId}`);
        if (btn) {
            btn.classList.remove('btn-light');
            btn.classList.add('btn-success'); // Đổi màu thành xanh khi đã chọn
        }
    }

    // Gán sự kiện cho tất cả các radio button
    document.querySelectorAll('input[type="radio"]').forEach(input => {
        input.addEventListener('change', function() {
            let questionId = this.name.match(/\d+/)[0]; // Lấy ID của câu hỏi
            markAnswered(questionId);
        });
    });

</script>
@endsection
