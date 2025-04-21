@extends('layouts.auth-layout')

@section('title', 'Xác nhận mật khẩu')

@section('content')
<div class="auth-form">
    <div class="form-title">Xác nhận mật khẩu</div>
    <p class="mb-4 text-muted">Vui lòng xác nhận mật khẩu của bạn trước khi tiếp tục.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror"
                   name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mt-3 d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">
                Xác nhận
            </button>

            @if (Route::has('password.request'))
                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </div>
    </form>
</div>
@endsection
