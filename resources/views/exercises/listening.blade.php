@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <div class="mb-4 text-center mt-4">
            <h2 class="fw-bold text-primary">{{ $topic->name }}</h2>
            <h4 class="text-secondary">{{ $exercise->title }}</h4>
        </div>

        <div class="row">
            @foreach ($audios as $audio)
                <div class="col-lg-6 mb-4"> 
                    <div class="border border-1 border-gray rounded p-4 shadow">
                        <div class="col-lg-12 mb-2">
                            <audio controls src="{{ asset('storage/audio/' . $audio->audio) }}" style="width: 100%;">
                                Your browser does not support audio!
                            </audio>
                        </div>
                        <form method="POST" action="{{ route('check.answer', $audio->id) }}" class="exercise-form">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Gõ những gì bạn nghe được</label>
                                <textarea class="form-control" name="answer" rows="4"></textarea>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <button class="btn btn-primary check-answer-btn" type="submit">Check đáp án</button>
                                <div>
                                    <button class="btn btn-warning hint-btn d-none" type="button" data-audio-id="{{ $audio->id }}">Gợi ý</button>
                                    <button class="btn btn-secondary show-answer-btn d-none" type="button" data-audio-id="{{ $audio->id }}">Hiện đáp án</button>
                                </div>
                            </div>
                        </form>
                        <div class="result mt-2"></div>
                        <div class="hint-container mt-2"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let answer = form.find('textarea[name="answer"]').val();
        let hintBtn = form.find('.hint-btn');
        let showAnswerBtn = form.find('.show-answer-btn');

        $.ajax({
            url: actionUrl,
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                answer: answer
            },
            success: function(response) {
                form.next('.result').html('<div class="alert alert-info">' + response.result + '</div>');

                if (response.correct === false) {
                    hintBtn.removeClass('d-none');
                    showAnswerBtn.removeClass('d-none');
                } else {
                    hintBtn.addClass('d-none');
                    showAnswerBtn.addClass('d-none');
                }
            },
            error: function() {
                alert("Lỗi! Vui lòng thử lại.");
            }
        });
    });

    $(document).on('click', '.hint-btn', function() {
        let audioId = $(this).data('audio-id');
        let btn = $(this);
        let hintContainer = btn.closest('.border').find('.hint-container');

        $.ajax({
            url: "{{ url('hint') }}/" + audioId,
            type: "GET",
            success: function(response) {
                hintContainer.html('<div class="alert alert-warning">Gợi ý: ' + response.hint + '</div>');
            },
            error: function() {
                alert("Lỗi khi lấy gợi ý!");
            }
        });
    });

    $(document).on('click', '.show-answer-btn', function() {
        let audioId = $(this).data('audio-id');
        let btn = $(this);
        let hintContainer = btn.closest('.border').find('.hint-container');
        let hintBtn = btn.siblings('.hint-btn');

        $.ajax({
            url: "{{ url('show-answer') }}/" + audioId,
            type: "GET",
            success: function(response) {
                hintContainer.html('<div class="alert alert-success">Đáp án: ' + response.answer + '</div>');
                hintBtn.addClass('d-none'); // Ẩn nút Gợi ý
                btn.addClass('d-none'); // Ẩn nút Hiện đáp án
            },
            error: function() {
                alert("Lỗi khi lấy đáp án!");
            }
        });
    });
});

    </script>
@endsection
