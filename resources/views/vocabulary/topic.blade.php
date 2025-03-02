@extends('layouts.app')

@section('content')
    <div class="container px-4 px-lg-5" style="min-height: 80vh;">
        <div class="card text-white bg-secondary my-5 py-4 text-center">
            <div class="card-body">
                <h2 class="text-white">All Topics</h2>
            </div>
        </div>
        
        <div class="list-group">
            @foreach ($topics as $topic)
                <div class="list-group-item d-flex justify-content-between align-items-center border rounded mb-2 shadow-sm">
                    <a href="{{ route('default.vocabulary', $topic->id) }}" class="text-decoration-none text-dark fw-bold">{{ $topic->name }}</a>
                    <div>
                        <a href="{{ route('review.vocabulary', $topic->id) }}" class="btn btn-primary btn-sm">Ôn tập lại</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection