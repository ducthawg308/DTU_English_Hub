@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row bootstrap snippets bootdeys" id="store-list">
            @foreach ($exams as $exam)
                <div class="col-md-6 col-xs-12">
                    <div class="panel" style="background-color: #e4e4e4; border-radius: 10px; padding: 15px; margin-bottom: 20px;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <a href="#"><img src="https://www.bootdey.com/image/300x300/FF4500/000000" class="img-responsive"></a>
                                </div>
                                <div class="col-sm-7">
                                    <h4 class="title-store">
                                        <strong><a href="#">{{ $exam->name }}</a></strong>
                                    </h4>
                                    <hr>
                                    <p>Thời gian làm bài: {{ $exam->time }}p</p>
                                    <p>Tổng số câu hỏi: {{ $exam->total_questions }}</p>
                                    <p>
                                        <a href="#" class="btn btn-default" disabled="" data-original-title="" title="">Level: {{ $exam->level->name}}</a>
                                        <a href="{{ route('exam.detail', $exam->id) }}" class="btn btn-warning pull-right">Thi thử</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
