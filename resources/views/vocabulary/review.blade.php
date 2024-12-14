@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <h4 class="text-center mb-4">Điền từ</h4>
        <div class="d-flex justify-content-center mb-3">
            <button id="play-sound" class="btn btn-link">
                <img src="https://img.icons8.com/ios-filled/50/000000/speaker.png" alt="Play Sound" style="width: 24px; height: 24px;">
            </button>
        </div>
        <div id="card-container" class="text-center mb-4">
            <!-- Nội dung câu hỏi sẽ được render tại đây bằng JavaScript -->
        </div>
        <div class="d-flex justify-content-center">
            <input id="answer-input" type="text" class="form-control text-center" style="width: 200px;" placeholder="Nhập từ vào đây">
        </div>
        <div class="text-center mt-4">
            <button id="check-answer" class="btn btn-primary me-2">Kiểm tra</button>
            <button id="next-question" class="btn btn-secondary" disabled>Tiếp theo</button>
        </div>
        <p id="feedback" class="text-center mt-3"></p>
    </div>

    <script>
        const vocabularys = @json($vocabularys);

        let currentQuestionIndex = 0;

        // Hàm render câu hỏi
        function renderQuestion() {
            const currentWord = vocabularys[currentQuestionIndex];
            const revealedLetters = getRevealedLetters(currentWord.word); // Lấy từ với các chữ cái đã tiết lộ
            const wordMeaning = currentWord.meaning;

            // Render câu hỏi
            const cardContainer = document.getElementById('card-container');
            cardContainer.innerHTML = `
                <p><strong>${wordMeaning}</strong></p>
                <div class="d-flex justify-content-center">
                    ${revealedLetters}
                </div>
            `;

            // Reset input và feedback
            document.getElementById('answer-input').value = '';
            document.getElementById('feedback').textContent = '';
            document.getElementById('next-question').disabled = true;
            document.getElementById('play-sound').onclick = () => {
                speak(currentWord.word);
            };
        }

        function speak(text) {
            const msg = new SpeechSynthesisUtterance();
            msg.text = text;
            msg.lang = 'en-US';
            window.speechSynthesis.speak(msg);
        }

        // Hàm tạo từ với các chữ cái đã tiết lộ
        function getRevealedLetters(word) {
            const firstLetter = word[0];
            const lastLetter = word[word.length - 1];
            let revealed = `<span class="revealed-letter">${firstLetter}</span>`;
            for (let i = 1; i < word.length - 1; i++) {
                revealed += `<span class="blank">_</span>`;
            }
            revealed += `<span class="revealed-letter">${lastLetter}</span>`;
            return revealed;
        }

        // Hàm kiểm tra đáp án
        document.getElementById('check-answer').addEventListener('click', function () {
            const userAnswer = document.getElementById('answer-input').value.trim().toLowerCase();
            const correctAnswer = vocabularys[currentQuestionIndex].word.toLowerCase();
            const feedback = document.getElementById('feedback');

            if (userAnswer === correctAnswer) {
                feedback.textContent = "Chính xác! 🎉";
                feedback.classList.add('text-success');
                feedback.classList.remove('text-danger');
                document.getElementById('next-question').disabled = false;
            } else {
                feedback.textContent = "Sai rồi. Hãy thử lại! 😢";
                feedback.classList.add('text-danger');
                feedback.classList.remove('text-success');
            }
        });

        // Hàm chuyển sang câu hỏi tiếp theo
        document.getElementById('next-question').addEventListener('click', function () {
            if (currentQuestionIndex < vocabularys.length - 1) {
                currentQuestionIndex++;
                renderQuestion();
            } else {
                alert("Bạn đã hoàn thành tất cả các câu hỏi!");
            }
        });

        // Khởi tạo câu hỏi đầu tiên
        renderQuestion();
    </script>

    <style>
        .revealed-letter {
            font-weight: bold;
            font-size: 1.5rem;
            margin: 0 5px;
        }
        .blank {
            font-size: 1.5rem;
            margin: 0 5px;
            border-bottom: 2px solid #ccc;
            display: inline-block;
            width: 20px;
            text-align: center;
        }
    </style>
@endsection
