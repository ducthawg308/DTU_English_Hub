@extends('layouts.auth-layout')

@section('content')
    <div class="auth-form">
        <div class="form-title">Đăng nhập</div>
        <p class="text-center text-muted mb-4">Chào mừng đến với DTU English Hub</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox"
                       name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Nhớ đăng nhập</label>
            </div>

            <button type="submit" class="btn btn-primary">Đăng nhập</button>

            <div class="auth-footer mt-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                @endif
                <br />
                <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký!</a>
            </div>
        </form>
    </div>
@endsection
