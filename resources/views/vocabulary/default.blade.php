@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-end">
            <img src="https://img.icons8.com/ios-filled/50/000000/bookmark.png" alt="Wordnote" style="width: 24px; height: 24px;">
        </div>
        <div class="row justify-content-center">
            <div class="d-flex justify-content-center gap-5">
                <button id="play-sound" class="btn btn-link p-0 mt-2">
                    <img src="https://img.icons8.com/ios-filled/50/000000/speaker.png" alt="Play Sound" style="width: 30px; height: 30px;">
                </button>
                <button id="add-wordnote" class="btn btn-link p-0 mt-2">
                    <img src="https://img.icons8.com/ios/50/000000/plus--v1.png" alt="Add to Wordnote" style="width: 30px; height: 30px;">
                </button>
            </div>
            <div class="col-12 col-sm-8 col-md-6 d-flex justify-content-center">
                <div id="flashcard-container" class="flashcard-container" onclick="flipCard(this)">
                    <div class="flashcard">
                        <div class="front d-flex flex-column align-items-center p-3">
                            <div>
                                <strong id="word"></strong>
                                <strong id="type"></strong>
                            </div>
                            <p id="pronounce"></p>
                        </div>
                        
                        <div class="back d-flex flex-column align-items-center p-3">
                            <strong id="meaning"></strong>
                            <p id="example"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p id="example_note" class="text-center mt-5 mb-5"></p>
        <div class="mt-3 text-center">
            <div class="d-flex justify-content-center">
                <button id="next-btn" class="btn btn-primary me-2">Next</button>
            </div>
        </div>
    </div>

    <script>
        function flipCard(cardContainer) {
            const card = cardContainer.querySelector('.flashcard');
            card.classList.toggle('is-flipped');
        }
        const vocabularies = @json($vocabularys, JSON_UNESCAPED_UNICODE);
        let currentIndex = 0;

        function updateFlashcard() {
            if (currentIndex >= vocabularies.length) {
                alert('Bạn đã học hết tất cả từ vựng!');
                return;
            }

            const currentWord = vocabularies[currentIndex];
            document.getElementById('word').innerText = currentWord.word;
            document.getElementById('type').innerText = `(${currentWord.type_vocabulary.name})`;
            document.getElementById('pronounce').innerText = currentWord.pronounce;
            document.getElementById('meaning').innerText = currentWord.meaning;
            document.getElementById('example').innerText = currentWord.example;
            document.getElementById('example_note').innerText = currentWord.example;

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

        document.getElementById('next-btn').addEventListener('click', () => {
            currentIndex++;
            updateFlashcard();
        });

        updateFlashcard();
    </script>
@endsection
