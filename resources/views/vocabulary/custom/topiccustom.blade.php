@extends('layouts.app')
@section('content')
    <div class="container px-4 px-lg-5">
        <div class="card text-white bg-secondary my-5 py-4 text-center">
            <div class="card-body"><h2 class="text-white">All topic</h2></div>
        </div>
        <div class="list-group">
            @foreach ($topics as $topic)
                <a href="{{ route('learn.custom', $topic->id) }}" class="list-group-item">{{ $topic->name }}</a>    
            @endforeach
        </div>
    </div>
@endsection