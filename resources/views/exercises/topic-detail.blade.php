@extends('layouts.app')
@section('content')
    <div class="container px-4 px-lg-5">
        <div class="list-group">
            @foreach ($topic->listeningExercises as $exercise)
                <a href="{{ route('topic.listening', ['topicId' => $topic->id, 'id' => $exercise->id]) }}" class="list-group-item">
                    {{ $exercise->title }}
                </a>    
            @endforeach
        </div>
    </div>
@endsection