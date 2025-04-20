@extends('layouts.app')

@section('content')
    <div class="container d-flex my-5">
        <!-- Sidebar -->
        <div class="border rounded p-4 me-5 sticky-top" style="width: 320px; height: fit-content; top:120px">
            <h3 class="mb-4 fw-bold">{{ $exam->name }}</h3>

            <div class="text-center mb-3">
                <h4 class="fw-bold">Thời gian còn lại:</h4>
                <div id="timer" class="fs-3 text-danger fw-bold bg-light px-4 py-2 rounded d-inline-block shadow">
                    --:--
                </div>
            </div>
            <hr>

            <!-- Ô số câu hỏi -->
            <div class="d-grid gap-2 question-grid" style="grid-template-columns: repeat(6, 1fr);">
                @foreach ($questions as $index => $question)
                    @php
                        $answered = session("answers.{$question->id}", false);
                    @endphp
                    <a href="#question-{{ $question->id }}" 
                       id="question-btn-{{ $question->id }}"
                       class="btn {{ $answered ? 'btn-success' : 'btn-light' }} p-2 text-center">
                        {{ $loop->iteration }}
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <button type="button" class="btn btn-success w-100 px-4 py-2" onclick="document.getElementById('exam-form').submit();">
                    Nộp bài
                </button>
            </div>
        </div>

        <!-- Nội dung bài test -->
        <div class="flex-grow-1">
            <form id="exam-form" action="{{ route('exam.submit', $exam->id) }}" method="POST">
                @csrf
                @foreach ($questions as $index => $question)
                    <p id="question-{{ $question->id }}" class="mt-4 fs-5 fw-bold">
                        <strong>Câu {{ $loop->iteration }}:</strong> {{ $question->question }}
                    </p>
                    @foreach (['A', 'B', 'C', 'D'] as $option)
                        <label class="d-block fs-5">
                            <input type="radio" name="answers[{{ $question->id }}]"
                                   value="{{ $option }}"
                                   onchange="markAnswered({{ $question->id }})"
                                   {{ session("answers.{$question->id}") ? 'checked' : '' }}>
                            {{ $question['option_' . strtolower($option)] }}
                        </label>
                    @endforeach
                @endforeach
            </form>
        </div>
    </div>

    <!-- CSS tuỳ chỉnh -->
    <style>
        .question-grid a {
            min-width: 40px;
            height: 45px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <!-- Script xử lý thời gian và đánh dấu -->
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
                btn.classList.add('btn-success');
            }
        }

        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', function () {
                let questionId = this.name.match(/\d+/)[0];
                markAnswered(questionId);
            });
        });
    </script>
@endsection
