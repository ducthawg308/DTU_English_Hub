@extends('layouts.app')
@section('content')
    <div class="container text-center my-5">
        <h2 class="mb-4">Donate cho DailyDictation</h2>

        <form method="POST" action="{{ route('donate.generate') }}" class="mb-4">
            @csrf
            <input type="number" name="amount" min="1000" class="form-control w-25 mx-auto" placeholder="Nhập số tiền muốn donate!">
            <button type="submit" class="btn btn-primary mt-2">Tạo QR</button>
        </form>

        @isset($qrUrl)
            <div>
                <img src="{{ $qrUrl }}" alt="QR Code Donate" class="border p-2">
            </div>
        @endisset
    </div>
@endsection
