@extends('layouts.auth-layout')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="auth-form">
    <div class="form-title">Đặt lại mật khẩu</div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary w-100">
                Gửi liên kết đặt lại mật khẩu
            </button>
        </div>
    </form>
</div>
@endsection
