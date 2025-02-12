@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="text-center mb-4">{{ $exam->name}}</h2>

    <form action="{{ route('exam.submit', $exam->id) }}" method="POST">
        @csrf
        @foreach ($questions as $index => $question)
            <p class="mt-4"><strong>Câu {{ $loop->iteration }}:</strong> {{ $question->question }}</p>
            @foreach (['A', 'B', 'C', 'D'] as $option)
                <label>
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required>
                    {{ $question['option_' . strtolower($option)] }}
                </label><br>
            @endforeach
        @endforeach
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Nộp bài</button>
        </div>
    </form>
</div>
@endsection
