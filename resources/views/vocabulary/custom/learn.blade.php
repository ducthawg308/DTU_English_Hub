@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <div class="row">
            @foreach ($vocabularys as $vocabulary)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="flashcard-container" onclick="flipCard(this)">
                        <div class="flashcard">
                            <div class="front d-flex flex-column align-items-center p-3">
                                <div>
                                    <strong>{{$vocabulary->word}}</strong>
                                    <strong>({{$vocabulary->typeVocabulary->name}})</strong>
                                </div>
                                <p>{{$vocabulary->pronounce}}</p>
                            </div>
                            <div class="back d-flex flex-column align-items-center p-3">
                                <strong>{{$vocabulary->meaning}}</strong>
                                <p>{{$vocabulary->example}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-3 text-center">
        <button id="next-btn" class="btn btn-primary">Next</button>
        <button id="prev-btn" class="btn btn-secondary me-2">Đã biết từ này</button>
    </div>

    <script>
        function flipCard(cardContainer) {
            const card = cardContainer.querySelector('.flashcard');
            card.classList.toggle('is-flipped');
        }
    </script>
@endsection