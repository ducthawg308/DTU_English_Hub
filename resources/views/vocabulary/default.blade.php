@extends('layouts.app')
@section('content')
    <div class="container border rounded-3 shadow my-5 p-5">
        <div class="d-flex justify-content-center align-items-center mb-4">
            <h1 class="h3 fw-bold text-primary display-6">Topic: {{ $topic->name }}</h1>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-lg btn-white custom-btn me-2 sound-btn">
                        <i class="fas fa-volume-up"></i>
                    </button>
                    <button class="btn btn-lg btn-white custom-btn me-2 sound-btn">
                        🐌
                    </button>
                </div>
            </div>
    
            <div class="flashcard-container mt-4" onclick="flipCard(this)">
                <div class="flashcard">
                    <div class="front text-center p-3 flex-column">
                        <strong class="fs-3" id="word">Word</strong>
                        <p class="fs-5" id="pronounce">/Pronunciation/</p>
                        <strong class="" id="meaning">Meaning</strong>
                    </div>
                    <div class="back text-center p-3 flex-column">
                        <img id="word-image" src="{{ asset('img/vocab/default.jpg') }}" alt="Vocabulary Image" class="img-fluid mb-3" style="max-height: 150px;">
                        <p class="fs-5" id="example">Example sentence</p>
                    </div>
                </div>
            </div>
        </div>
                            
        <div class="d-flex justify-content-between align-items-center mt-5">
            <button class="btn btn-white custom-btn favorite-btn">
                <i class="fas fa-star"></i>
            </button>
            <div>
                <button class="btn btn-white custom-btn prev-btn me-2">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <span class="text-muted" id="progress">1 / {{ count($vocabularys) }}</span>
                <button class="btn btn-white custom-btn next-btn ms-2">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-white custom-btn expand-btn">
                    <i class="fas fa-expand"></i>
                </button>                
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const flashcardContainer = document.querySelector(".flashcard-container");
            if (flashcardContainer) {
                flashcardContainer.addEventListener("click", function () {
                    const flashcard = this.querySelector(".flashcard");
                    flashcard.classList.toggle("is-flipped");
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
    let currentIndex = 0;
    const flashcard = document.querySelector(".flashcard");
    const wordElement = document.getElementById("word");
    const pronounceElement = document.getElementById("pronounce");
    const meaningElement = document.getElementById("meaning");
    const exampleElement = document.getElementById("example");
    const imageElement = document.getElementById("word-image");
    const soundButton = document.querySelector(".sound-btn");
    const slowSoundButton = document.querySelector(".sound-btn:nth-child(2)");

    // Dữ liệu từ vựng từ Blade
    let vocabularys = @json($vocabularys);

    if (!vocabularys || vocabularys.length === 0) {
        console.error("Dữ liệu từ vựng trống!");
        return;
    }

    function updateFlashcard(index) {
        if (!flashcard) return;

        flashcard.classList.add("hide");

        setTimeout(() => {
            wordElement.textContent = vocabularys[index].word;
            pronounceElement.textContent = vocabularys[index].pronounce;
            meaningElement.textContent = vocabularys[index].meaning;
            exampleElement.textContent = vocabularys[index].example;

            // Cập nhật hình ảnh
            let imagePath = vocabularys[index].image 
                ? "{{ asset('img/vocab') }}/" + vocabularys[index].image 
                : "{{ asset('img/vocab/default.jpg') }}";
            imageElement.src = imagePath;

            flashcard.classList.remove("hide");
        }, 500);
    }

    // Sự kiện phát âm khi bấm nút loa
    function speakWord(word, rate = 0.9) {
        if ("speechSynthesis" in window) {
            let speech = new SpeechSynthesisUtterance(word);
            speech.lang = "en-US"; // Ngôn ngữ tiếng Anh
            speech.rate = rate; // Tốc độ đọc
            window.speechSynthesis.speak(speech);
        } else {
            alert("Trình duyệt của bạn không hỗ trợ tính năng đọc văn bản!");
        }
    }

    // Gán sự kiện click cho nút loa
    soundButton.addEventListener("click", function () {
        speakWord(vocabularys[currentIndex].word, 1);
    });

    slowSoundButton.addEventListener("click", function () {
        speakWord(vocabularys[currentIndex].word, 0.3);
    });

    document.querySelector(".next-btn").addEventListener("click", function () {
        if (currentIndex < vocabularys.length - 1) {
            currentIndex++;
            updateFlashcard(currentIndex);
            updateProgress();
        }
    });

    document.querySelector(".prev-btn").addEventListener("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateFlashcard(currentIndex);
            updateProgress();
        }
    });

    function updateProgress() {
        document.getElementById("progress").textContent = `${currentIndex + 1} / ${vocabularys.length}`;
    }

    // Load từ đầu tiên khi trang mở
    updateFlashcard(currentIndex);
    updateProgress();
});



        document.addEventListener("DOMContentLoaded", function () {
        const expandButton = document.querySelector(".custom-btn.expand-btn");
        const header = document.querySelector("header");
        const footer = document.querySelector("footer");

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    if (header) header.style.display = "none";
                    if (footer) footer.style.display = "none";
                });
            } else {
                document.exitFullscreen().then(() => {
                    if (header) header.style.display = "";
                    if (footer) footer.style.display = "";
                });
            }
        }

        expandButton.addEventListener("click", toggleFullScreen);
    });
    </script>
@endsection
