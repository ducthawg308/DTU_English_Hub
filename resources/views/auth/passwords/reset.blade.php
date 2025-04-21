@extends('layouts.auth-layout')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="auth-form">
    <div class="form-title">Đặt lại mật khẩu</div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ $email ?? old('email') }}" required autofocus>

            @error('email')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirm" class="form-label">Nhập lại mật khẩu</label>
            <input id="password-confirm" type="password"
                   class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary w-100">
                Đặt lại mật khẩu
            </button>
        </div>
    </form>
</div>
@endsection
