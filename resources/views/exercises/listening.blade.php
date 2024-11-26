@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-lg-5 mb-2">
            <audio controls="" src="{{ asset('storage/audio/'. $exercise->audio) }}" style="width: 100%;">Your browser does not support audio!</audio>
        </div>
        <form method="POST" action="{{route('check.answer',$exercise->id)}}">
        @csrf
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Gõ những gì bạn nghe được</label>
                <textarea class="form-control" name="answer" id="exampleFormControlTextarea1" rows="4"></textarea>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <button class="btn btn-primary" type="submit" value="Check đáp án" name="btn-add">Check đáp án</button>
            </div>  
        </form>

        @if (isset($result))
        <div class="mt-4">
            <h5>Kết quả:</h5>
            <p>{!! $result !!}</p>
        </div>
        @endif
    </div>
@endsection