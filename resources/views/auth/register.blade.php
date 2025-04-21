@extends('layouts.auth-layout')

@section('title', 'Đăng ký')

@section('content')
<div class="auth-form">
    <div class="form-title">Đăng ký</div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên đầy đủ</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" name="password"
                    required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="password-confirm" class="form-label">Nhập lại mật khẩu</label>
                <input id="password-confirm" type="password" class="form-control"
                    name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="mt-3 mb-0">
            <button type="submit" class="btn btn-primary">
                Đăng ký
            </button>
        </div>
    </form>
    <div class="auth-footer mt-4">
        <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập!</a>
    </div>
</div>
@endsection
