@extends('layouts.app')
@section('content')
<div class="container border rounded-3 shadow my-4 p-3 p-sm-4 p-md-5">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <h1 class="h3 fw-bold text-primary fs-4 fs-md-5">Topic: {{ $topic->name }}</h1>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex align-items-center flex-wrap">
                    <button class="btn btn-lg btn-white custom-btn me-1 sound-btn">
                        <i class="fas fa-volume-up"></i>
                    </button>
                    <button class="btn btn-lg btn-white custom-btn me-1 slow-sound-btn">
                        🐌
                    </button>
                </div>
            </div>
    
            <div class="flashcard-container mt-3">
                <div class="flashcard">
                    <div class="front text-center p-2 p-sm-3 flex-column">
                        <strong class="fs-4 fs-sm-3" id="word">Word</strong>
                        <p class="fs-6 fs-sm-5" id="pronounce">/Pronunciation/</p>
                        <strong class="fs-5 fs-sm-4" id="meaning">Meaning</strong>
                    </div>
                    <div class="back text-center p-2 p-sm-3 flex-column">
                        <img id="word-image" src="{{ asset('img/vocab/default.jpg') }}" alt="Vocabulary Image" class="img-fluid mb-2" style="max-height: 120px; max-width: 100%; border-radius: 10px;">
                        <p class="fs-6 fs-sm-5" id="example">Example sentence</p>
                    </div>
                </div>
            </div>
        </div>
                            
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
            <button class="btn btn-white custom-btn favorite-btn mb-2">
                <i class="fa-solid fa-heart"></i>
            </button>
            <div class="d-flex align-items-center">
                <button class="btn btn-white custom-btn prev-btn me-2 mb-2">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <span class="text-muted fs-6 fs-sm-5" id="progress">1 / {{ count($vocabularys) }}</span>
                <button class="btn btn-white custom-btn next-btn ms-2 mb-2">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-white custom-btn expand-btn mb-2">
                    <i class="fas fa-expand"></i>
                </button>                
            </div>
        </div>
        
        <div class="d-flex justify-content-center align-items-center flex-wrap mt-3">
            <button class="btn btn-success custom-btn me-1 mb-2 memorize-btn" data-level="1">Dễ nhớ</button>
            <button class="btn btn-warning custom-btn me-1 mb-2 memorize-btn" data-level="2">Dễ quên</button>
            <button class="btn btn-danger custom-btn mb-2 memorize-btn" data-level="3">Rất dễ quên</button>
        </div>
    </div>

    <!-- Toast container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="memorizeToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Thông báo</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Đã gửi đánh giá từ vựng!
            </div>
        </div>
    </div>

<script>
    const flashcard = {
        currentIndex: 0,
        vocabularys: @json($vocabularys),
        elements: {
            flashcard: document.querySelector(".flashcard"),
            container: document.querySelector(".flashcard-container"),
            word: document.getElementById("word"),
            pronounce: document.getElementById("pronounce"),
            meaning: document.getElementById("meaning"),
            example: document.getElementById("example"),
            image: document.getElementById("word-image"),
            progress: document.getElementById("progress"),
            soundBtn: document.querySelector(".sound-btn"),
            slowSoundBtn: document.querySelector(".slow-sound-btn"),
            nextBtn: document.querySelector(".next-btn"),
            prevBtn: document.querySelector(".prev-btn"),
            expandBtn: document.querySelector(".expand-btn"),
            memorizeBtns: document.querySelectorAll(".memorize-btn"),
        },

        init() {
            if (!this.vocabularys || this.vocabularys.length === 0) {
                console.error("Dữ liệu từ vựng trống!");
                return;
            }
            this.bindEvents();
            this.updateFlashcard(this.currentIndex);
            this.updateProgress();
        },

        bindEvents() {
            this.elements.container.addEventListener("click", () => this.flipCard());
            this.elements.soundBtn.addEventListener("click", () => this.speakWord(this.vocabularys[this.currentIndex].word, 1));
            this.elements.slowSoundBtn.addEventListener("click", () => this.speakWord(this.vocabularys[this.currentIndex].word, 0.3));
            this.elements.nextBtn.addEventListener("click", () => this.nextCard());
            this.elements.prevBtn.addEventListener("click", () => this.prevCard());
            this.elements.expandBtn.addEventListener("click", () => this.toggleFullScreen());
            this.elements.memorizeBtns.forEach(btn => 
                btn.addEventListener("click", () => this.handleMemorize(btn.dataset.level))
            );
        },

        flipCard() {
            this.elements.flashcard.classList.toggle("is-flipped");
        },

        updateFlashcard(index) {
            if (!this.elements.flashcard) return;

            this.elements.flashcard.classList.add("hide");
            setTimeout(() => {
                this.elements.word.textContent = this.vocabularys[index].word;
                this.elements.pronounce.textContent = this.vocabularys[index].pronounce;
                this.elements.meaning.textContent = this.vocabularys[index].meaning;
                this.elements.example.textContent = this.vocabularys[index].example;

                const imagePath = this.vocabularys[index].image 
                    ? `{{ asset('img/vocab') }}/${this.vocabularys[index].image}`
                    : `{{ asset('img/vocab/default.jpg') }}`;
                this.elements.image.src = imagePath;

                this.elements.flashcard.classList.remove("hide");
            }, 500);
        },

        updateProgress() {
            this.elements.progress.textContent = `${this.currentIndex + 1} / ${this.vocabularys.length}`;
        },

        speakWord(word, rate) {
            if ("speechSynthesis" in window) {
                const speech = new SpeechSynthesisUtterance(word);
                speech.lang = "en-US";
                speech.rate = rate;
                window.speechSynthesis.speak(speech);
            } else {
                alert("Trình duyệt của bạn không hỗ trợ tính năng đọc văn bản!");
            }
        },

        nextCard() {
            if (this.currentIndex < this.vocabularys.length - 1) {
                this.currentIndex++;
                this.updateFlashcard(this.currentIndex);
                this.updateProgress();
            }
        },

        prevCard() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
                this.updateFlashcard(this.currentIndex);
                this.updateProgress();
            }
        },

        toggleFullScreen() {
            const header = document.querySelector("header");
            const footer = document.querySelector("footer");

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
        },

        handleMemorize(level) {
            const vocabularyId = this.vocabularys[this.currentIndex].id;
            
            fetch('/memorize', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'  // Yêu cầu phản hồi dạng JSON
                },
                body: JSON.stringify({ vocabulary_id: vocabularyId, level: parseInt(level) })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response:', text);
                        throw new Error('Có lỗi xảy ra khi gửi yêu cầu');
                    });
                }
                return response.json();
            })
            .then(data => {
                this.showToast(`Đã thêm vào box: ${this.getLevelText(level)}`);
            })
            .catch(error => {
                console.error('Error:', error);
                this.showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
            });
        },
        showToast(message, type = 'success') {
            const toastEl = document.getElementById('memorizeToast');
            const toastBody = toastEl.querySelector('.toast-body');
            toastBody.textContent = message;
            toastEl.classList.remove('bg-success', 'bg-danger');
            toastEl.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        },

        getLevelText(level) {
            switch (parseInt(level)) {
                case 1: return 'Dễ nhớ';
                case 2: return 'Dễ quên';
                case 3: return 'Rất dễ quên';
                default: return '';
            }
        }
    };

    document.addEventListener("DOMContentLoaded", () => flashcard.init());
</script>
@endsection