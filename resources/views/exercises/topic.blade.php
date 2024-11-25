@extends('layouts.app')
@section('content')
    <div class="container px-4 px-lg-5">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="{{ asset('img/listen.jpg') }}" alt="..." /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light">Business Name or Tagline</h1>
                <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                <a class="btn btn-primary" href="#!">Call to Action!</a>
            </div>
        </div>
        <!-- Call to Action-->
        <div class="card text-white bg-secondary my-5 py-4 text-center">
            <div class="card-body"><h2 class="text-white">All topic</h2></div>
        </div>
        <!-- Content Row-->
        <div class="row gx-4 gx-lg-5"> 
            @foreach ($topics as $topic)
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">{{$topic->name}}</h2>
                            <p class="text-success">Level: {{$topic->level->name}}</p>
                            <p class="text-warning">{{$topic->total_less}} lessons</p>
                            <p class="card-text">{{$topic->desc}}</p>
                        </div>
                        <div class="card-footer"><a class="btn btn-primary btn-sm" href="{{route('topic.show',$topic->id)}}">Chi tiết</a></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection