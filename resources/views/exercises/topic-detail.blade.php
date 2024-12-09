@extends('layouts.app')
@section('content')
    <div class="container px-4 px-lg-5">
        <div class="list-group">
            @foreach ($topic->listeningExercises as $index => $exercise)
                <a 
                    href="{{ $index == 0 || $isPurchased ? route('topic.listening', ['topicId' => $topic->id, 'id' => $exercise->id]) : '#' }}" 
                    class="list-group-item {{ $index > 0 && !$isPurchased ? 'disabled' : '' }}"
                >
                    {{ $exercise->title }}
                </a>    
            @endforeach
        </div>
    </div>
@endsection
