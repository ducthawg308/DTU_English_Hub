@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-4 font-weight-bold mb-0">Bài viết nổi bật</h1>
            <a href="{{ route('create.community') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm d-flex align-items-center">
                <i class="fa-solid fa-pen-to-square me-2"></i> Viết blog
            </a>
        </div>
        <p class="text-muted mb-5">Tổng hợp những chia sẻ truyền cảm hứng từ người học thật, kinh nghiệm học tiếng Anh và mẹo ôn luyện hiệu quả.</p>
        <div class="row">
            <div class="col-lg-8">
                @foreach ($blogs as $blog)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="media">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($blog->user->name) }}"
                                        class="rounded-circle me-3"
                                        width="50" height="50" alt="Avatar">
                                    <div class="flex-fill">
                                        <h5 class="mt-0 d-flex align-items-center mb-0">
                                            {{ $blog->user->name ?? 'Ẩn danh' }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h4 class="font-weight-bold"><a href="{{ route('detail.community', $blog->id) }}">{{ $blog->title }}</a></h4>
                                    <p class="text-muted">{{ Str::limit(strip_tags($blog->content), 200, '...') }}</p>
                                    <div class="d-flex align-items-center justify-content-between text-muted">
                                        <span>{{ $blog->created_at->diffForHumans() }}</span>
                                        <div class="d-flex align-items-center gap-3">
                                            <button class="btn-like btn btn-sm {{ auth()->check() && $blog->isLikedBy(auth()->user()) ? 'btn-danger' : 'btn-outline-danger' }}"
                                                data-blog-id="{{ $blog->id }}"
                                                data-url="{{ route('like.community', $blog->id) }}">
                                                <i class="fa-solid fa-heart"></i> <span class="like-count">{{ $blog->likes->count() }}</span>
                                            </button>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1 shadow-sm dropdown-toggle" type="button"
                                                    id="dropdownShareButton{{ $blog->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-share-alt me-1"></i> Chia sẻ
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dropdownShareButton{{ $blog->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('detail.community', $blog->slug)) }}"
                                                            target="_blank">
                                                            <i class="fab fa-facebook text-primary me-2"></i> Facebook
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ urlencode(route('detail.community', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                                                            target="_blank">
                                                            <i class="fab fa-twitter text-info me-2"></i> Twitter
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('detail.community', $blog->slug)) }}&title={{ urlencode($blog->title) }}"
                                                            target="_blank">
                                                            <i class="fab fa-linkedin text-primary me-2"></i> LinkedIn
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4">
            <div class="position-sticky" style="top: 100px;">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">XEM CÁC BÀI VIẾT THEO CHỦ ĐỀ</h5>
                        <div class="d-flex flex-wrap">
                            <span class="badge badge-light text-dark mr-2 mb-2">Luyện nghe / Từ vựng</span>
                            <span class="badge badge-light text-dark mr-2 mb-2">IELTS / TOEIC</span>
                            <span class="badge badge-light text-dark mr-2 mb-2">Ngữ pháp</span>
                            <span class="badge badge-light text-dark mr-2 mb-2">Phương pháp</span>
                            <span class="badge badge-light text-dark mr-2 mb-2">Ôn tập</span>
                            <span class="badge badge-light text-dark mr-2 mb-2">Kinh nghiệm</span>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <img src="{{ asset('img/blog.jpg') }}" class="card-img-top" alt="Advertisement for HTML CSS Pro course">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">DTU English Hub</h5>
                        <ul class="list-unstyled text-muted">
                            <li><i class="fa-solid fa-check"></i> Chia sẻ kinh nghiệm học tiếng Anh</li>
                            <li><i class="fa-solid fa-check"></i> Thảo luận về các chủ đề IELTS / TOEIC</li>
                            <li><i class="fa-solid fa-check"></i> Giao lưu với người học từ khắp nơi</li>
                            <li><i class="fa-solid fa-check"></i> Học hỏi qua các bài đăng thực tế</li>
                            <li><i class="fa-solid fa-check"></i> Nhận phản hồi và tài liệu miễn phí</li>
                        </ul>
                        <a href="#" class="text-primary font-weight-bold">Tìm hiểu thêm &gt;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-like', function (e) {
                e.preventDefault();
                
                let button = $(this);
                let blogId = button.data('blog-id');

                $.ajax({
                    url: `/community/${blogId}/like`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.status === 'liked') {
                            button.removeClass('btn-outline-danger').addClass('btn-danger');
                        } else if (response.status === 'unliked') {
                            button.removeClass('btn-danger').addClass('btn-outline-danger');
                        }

                        button.find('.like-count').text(response.likes_count);
                    },
                    error: function (xhr) {
                        if (xhr.status === 401) {
                            alert('Bạn cần đăng nhập để thích bài viết!');
                        } else {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    }
                });
            });
        });
    </script>
@endsection
