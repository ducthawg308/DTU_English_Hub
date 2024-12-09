@extends('layouts.app')
@section('content')
    <div class="container px-4 px-lg-5">
        <div class="card text-white bg-secondary my-5 py-4 text-center">
            <div class="card-body"><h2 class="text-white">All topic</h2></div>
        </div>
        <div class="list-group">
            @foreach ($topics as $topic)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('default.vocabulary', $topic->id) }}" class="text-decoration-none">{{ $topic->name }}</a>
                    <a href="{{ route('review.vocabulary', $topic->id) }}" class="btn btn-primary">Ôn tập lại topic này</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
