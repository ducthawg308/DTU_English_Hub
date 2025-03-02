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

                        <form method="POST" action="{{ route('check.answer', $audio->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Gõ những gì bạn nghe được</label>
                                <textarea class="form-control" name="answer" rows="4"></textarea>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <button class="btn btn-primary" type="submit">Check đáp án</button>
                            </div>
                        </form>
                        <div class="result mt-2"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('form').on('submit', function(event) {
            event.preventDefault(); // Ngăn chặn load lại trang
            
            let form = $(this);
            let actionUrl = form.attr('action'); // Lấy URL của form
            let answer = form.find('textarea[name="answer"]').val(); // Lấy câu trả lời của user
            
            $.ajax({
                url: actionUrl,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    answer: answer
                },
                success: function(response) {
                    form.next('.result').remove(); // Xóa kết quả cũ nếu có
                    form.after('<div class="result mt-2 alert alert-info">' + response.result + '</div>');
                },
                error: function(xhr) {
                    alert("Lỗi! Vui lòng thử lại.");
                }
            });
        });
    });
    </script>
@endsection
