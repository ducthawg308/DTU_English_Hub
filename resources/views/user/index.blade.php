@extends('layouts.app')
@section('content')
<div class="card-wrapper py-5">
    <div class="container">
        <div class="card custom-card">
            <div class="row g-0">
                <div class="col-md-4 border-end">
                    <div class="card-body custom-card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.5rem;">F8</div>
                            <h1 class="ms-3 h4">Cài đặt tài khoản</h1>
                        </div>
                        <p class="text-muted mb-4">Quản lý cài đặt tài khoản của bạn như thông tin cá nhân, cài đặt bảo mật, quản lý thông báo, v.v.</p>
                        <div class="list-group">
                            <button class="list-group-item list-group-item-action d-flex align-items-center bg-dark text-white custom-list-group-item">
                                <i class="fas fa-user me-3"></i> Thông tin cá nhân
                            </button>
                            <button class="list-group-item list-group-item-action d-flex align-items-center custom-list-group-item">
                                <i class="fas fa-shield-alt me-3"></i> Mật khẩu và bảo mật
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body custom-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h5">Thông tin cá nhân</h2>
                            <button class="btn btn-link text-muted">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <p class="text-muted mb-4">Quản lý thông tin cá nhân của bạn.</p>
                        <div class="mb-5">
                            <h3 class="h6 mb-3">Thông tin cơ bản</h3>
                            <p class="text-muted mb-4">Quản lý tên hiển thị, tên người dùng, bio và avatar của bạn.</p>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center custom-list-group-item">
                                    <div>
                                        <p class="text-muted mb-1">Họ và tên</p>
                                        <p class="mb-0">Đức Thắng Nguyễn</p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center custom-list-group-item">
                                    <div>
                                        <p class="text-muted mb-1">Tên người dùng</p>
                                        <p class="mb-0">nguyenducthang19</p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center custom-list-group-item">
                                    <div>
                                        <p class="text-muted mb-1">Giới thiệu</p>
                                        <p class="mb-0">Chưa cập nhật</p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center custom-list-group-item">
                                    <div>
                                        <p class="text-muted mb-1">Ảnh đại diện</p>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.5rem;">N</div>
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="h6 mb-3">Thông tin mạng xã hội</h3>
                            <p class="text-muted mb-4">Quản lý liên kết tới các trang mạng xã hội của bạn.</p>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center custom-list-group-item">
                                    <div>
                                        <p class="text-muted mb-1">Trang web cá nhân</p>
                                        <p class="mb-0">Chưa cập nhật</p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center custom-list-group-item">
                                    <div>
                                        <p class="text-muted mb-1">GitHub</p>
                                        <p class="mb-0">Chưa cập nhật</p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card-wrapper {
        background: linear-gradient(to right, #ffe4e1, #ffffff, #add8e6);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .custom-card {
        
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .custom-card-header {
        border-bottom: none;
    }
    .custom-card-body {
        padding: 2rem;
    }
    .custom-list-group-item {
        border: none;
        border-radius: 0.5rem;
        background-color: #f8f9fa;
    }
    .custom-list-group-item i {
        color: #6c757d;
    }
</style>
@endsection