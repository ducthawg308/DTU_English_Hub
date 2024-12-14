@extends('layouts.app')
@section('content')
    <div class="container">
        @foreach ($audios as $audio)
            <div class="mb-5 border border-2 border-primary rounded p-4">
                <div class="col-lg-5 mb-2">
                    <audio controls="" src="{{ asset('storage/audio/' . $audio->audio) }}" style="width: 100%;">Your browser does not support audio!</audio>
                </div>

                <form method="POST" action="{{ route('check.answer', $audio->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Gõ những gì bạn nghe được</label>
                        <textarea class="form-control" name="answer" rows="4"></textarea>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <button class="btn btn-primary" type="submit" name="btn-check">Check đáp án</button>
                    </div>
                </form>

                @if (isset($results[$audio->id]))
                    <div class="mt-1">
                        <h5>Kết quả:</h5>
                        <p>{!! $results[$audio->id] !!}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
