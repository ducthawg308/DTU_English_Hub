@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="text-center">
            <h2 class="mb-4 text-primary fw-bold">Ủng hộ cho <span class="text-success">DTU English Hub</span></h2>
            <p class="mb-4 text-muted">Mỗi đóng góp của bạn là động lực to lớn giúp chúng tôi phát triển nền tảng học tiếng Anh tốt hơn cho sinh viên DTU!</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('donate.generate') }}" class="card shadow p-4">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Số tiền muốn ủng hộ (VND)</label>
                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            min="1000"
                            class="form-control @error('amount') is-invalid @enderror"
                            placeholder="Nhập số tiền"
                            required
                        >
                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Tạo mã QR để ủng hộ</button>
                    </div>
                </form>
            </div>
        </div>

        @isset($qrUrl)
            <div class="row justify-content-center mt-5">
                <div class="col-md-6 text-center">
                    <h5 class="mb-3">Quét mã QR bên dưới để hoàn tất ủng hộ</h5>
                    <img src="{{ $qrUrl }}" alt="QR Code Donate" class="img-fluid border p-2 rounded">
                </div>
            </div>
        @endisset
    </div>
@endsection
