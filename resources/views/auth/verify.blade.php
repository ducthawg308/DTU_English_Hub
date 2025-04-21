@extends('layouts.auth-layout')

@section('title', 'Xác minh địa chỉ email')

@section('content')
<div class="auth-form">
    <div class="form-title">Xác minh địa chỉ email</div>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.
        </div>
    @endif

    <p>
        Trước khi tiếp tục, vui lòng kiểm tra email của bạn để lấy liên kết xác minh.
        Nếu bạn không nhận được email,
    </p>

    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
            bấm vào đây để yêu cầu lại
        </button>.
    </form>
</div>
@endsection
