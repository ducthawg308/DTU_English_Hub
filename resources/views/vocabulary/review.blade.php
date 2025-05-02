@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 px-2 px-sm-3 px-md-4">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <h1 class="h3 fw-bold text-primary fs-4 fs-md-5">Topic: {{ $topic->name }}</h1>
        </div>

        <div id="vocab-container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <i class="fas fa-times text-muted fs-5"></i>
                <div class="progress flex-grow-1 mx-2">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%;"
                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <img src="https://storage.googleapis.com/a1aa/image/PD6KjzeKbD3-_SfZHT-8D4kcv_v1NqWykrKqTdud2so.jpg"
                     alt="small orange icon" class="rounded-circle" width="20" height="20">
            </div>
            @foreach ($vocabularys as $index => $vocab)
                <div class="vocab-card bg-white w-100 max-w-sm mx-auto p-3 p-sm-4 rounded shadow mb-3"
                     data-word="{{ $vocab->word }}"
                     style="{{ $index === 0 ? '' : 'display: none;' }}">
                    <div class="text-center mb-3">
                        <h6 class="text-muted fs-6 fs-sm-5">Điền từ</h6>
                        <h4 class="fw-bold fs-5 fs-sm-4">{{ $vocab->meaning }} ({{ $vocab->typeVocabulary->name }})</h4>
                    </div>

                    <div class="d-flex justify-content-center mb-3">
                        <div class="rounded px-2 py-2 d-inline-block position-relative input-container">
                            @foreach (str_split($vocab->word) as $letter)
                                <input type="text" class="letter-input" maxlength="1">
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <button id="check-btn" class="btn btn-success btn-sm btn-lg px-4 mt-3">Kiểm tra</button>
        </div>
    </div>

    <style>
        .letter-input {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border: none;
            border-bottom: 2px solid gray;
            outline: none;
            margin: 0 3px;
            text-transform: uppercase;
            transition: all 0.2s ease-in-out;
        }

        .letter-input:focus {
            border-bottom: 2px solid orange;
        }

        .letter-input.correct {
            background-color: lightgreen;
        }

        .letter-input.wrong {
            background-color: lightcoral;
        }

        .input-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3px;
        }

        #vocab-container {
            width: 90%;
            max-width: 600px;
        }

        @media (max-width: 576px) {
            .letter-input {
                width: 30px;
                height: 40px;
                font-size: 20px;
                margin: 0 2px;
            }

            .input-container {
                gap: 2px;
            }
        }
    </style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const vocabCards = document.querySelectorAll(".vocab-card");
        const progressBar = document.querySelector(".progress-bar");
        let currentIndex = 0;

        function updateProgress() {
            let percent = ((currentIndex + 1) / vocabCards.length) * 100;
            progressBar.style.width = percent + "%";
            progressBar.setAttribute("aria-valuenow", percent);
        }

        function showCard(index) {
            vocabCards.forEach((card, i) => {
                card.style.display = i === index ? "block" : "none";
            });
            focusFirstInput();
            updateProgress();
        }

        function focusFirstInput() {
            let firstInput = vocabCards[currentIndex].querySelector(".letter-input");
            if (firstInput) firstInput.focus();
        }

        function checkWord() {
            let currentCard = vocabCards[currentIndex];
            let inputs = currentCard.querySelectorAll(".letter-input");
            let correctWord = currentCard.dataset.word.toUpperCase();
            let userInput = Array.from(inputs).map(input => input.value.toUpperCase()).join("");

            if (userInput === correctWord) {
                inputs.forEach(input => input.classList.add("correct"));
                setTimeout(() => {
                    currentIndex++;
                    if (currentIndex < vocabCards.length) {
                        showCard(currentIndex);
                    } else {
                        progressBar.style.width = "100%";
                        alert("Bạn đã hoàn thành!");
                    }
                }, 500);
            } else {
                inputs.forEach((input, index) => {
                    if (input.value.toUpperCase() !== correctWord[index]) {
                        input.classList.add("wrong");
                    } else {
                        input.classList.remove("wrong");
                    }
                });
            }
        }

        function setupLetterInputs() {
            document.querySelectorAll(".letter-input").forEach((input, index, inputs) => {
                input.addEventListener("input", function () {
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener("keydown", function (e) {
                    if (e.key === "Backspace" && index > 0 && this.value === "") {
                        inputs[index - 1].focus();
                    }
                });
            });
        }

        document.querySelector("#check-btn").addEventListener("click", checkWord);
        showCard(currentIndex);
        setupLetterInputs();
    });
</script>



@endsection
