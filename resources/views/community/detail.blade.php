@extends('layouts.app')
@section('content')
<!-- Bootstrap JS (v5) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <!-- Tiêu đề -->
                    <h1 class="article-title mb-4">{{ $blog->title }}</h1>

                    <!-- Tác giả -->
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($blog->user->name) }}"
                            class="rounded-circle me-3"
                            width="52" height="52" alt="Avatar">
                        <div>
                            <div class="d-flex align-items-center mb-1">
                                <span class="fw-medium">{{ $blog->user->name }}</span>
                                <i class="fas fa-check-circle text-primary ms-2"></i>
                            </div>
                            <div class="text-muted small">{{ $blog->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <!-- Nội dung bài viết -->
                    <div class="article-content">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>

            <!-- Bình luận -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="mb-3">Bình luận</h5>

                    <!-- Form gửi bình luận -->
                    <form id="comment-form" action="{{ route('storeComment.community') }}" method="POST">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                        <div class="mb-3">
                            <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Bình luận</button>
                        </div>
                    </form>

                    <!-- Toast message -->
                    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
                        <div id="comment-toast" class="toast align-items-center text-white bg-success border-0" role="alert">
                            <div class="d-flex">
                                <div class="toast-body" id="toast-message">
                                    Bình luận thành công!
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách bình luận -->
                    <hr class="my-4">
                    @foreach($blog->comments as $comment)
                        <div class="d-flex mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}"
                                 class="rounded-circle me-3"
                                 width="40" height="40" alt="Avatar">
                            <div>
                                <div class="fw-semibold">{{ $comment->user->name }}</div>
                                <div class="text-muted small">{{ $comment->created_at->diffForHumans() }}</div>
                                <p class="mt-1">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach

                    @if($blog->comments->isEmpty())
                        <p id="no-comments-message" class="text-muted">Chưa có bình luận nào.</p>
                    @endif
                </div>
            </div>

            <!-- Nút quay lại -->
            <div class="mt-4 text-end">
                <a href="{{ route('home.community') }}" class="btn btn-outline-secondary">← Quay về danh sách</a>
            </div>
        </div>
    </div>
</div>

<style>
    .article-title {
        font-size: 2rem;
        font-weight: bold;
    }
    .article-content p {
        line-height: 1.7;
        text-align: justify;
    }
    .article-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 1rem auto;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#comment-form').submit(function (e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    form[0].reset();

                    // ✅ Thêm bình luận mới vào DOM
                    let newComment = `
                        <div class="d-flex mb-3">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(res.user.name)}"
                                class="rounded-circle me-3"
                                width="40" height="40" alt="Avatar">
                            <div>
                                <div class="fw-semibold">${res.user.name}</div>
                                <div class="text-muted small">Vừa xong</div>
                                <p class="mt-1">${res.comment.content}</p>
                            </div>
                        </div>
                    `;

                    // Thêm vào trước phần tử đầu tiên có class d-flex hoặc p.text-muted
                    $('#comment-form').nextAll('hr, .d-flex, p.text-muted').first().before(newComment);

                    // Ẩn dòng "Chưa có bình luận nào." nếu có
                    $('#no-comments-message').hide();

                    // ✅ Hiển thị toast
                    $('#toast-message').text('Bình luận thành công!');
                    $('#comment-toast').removeClass('bg-danger').addClass('bg-success');
                    let toast = new bootstrap.Toast(document.getElementById('comment-toast'));
                    toast.show();
                },
                error: function (err) {
                    $('#toast-message').text('Gửi bình luận thất bại!');
                    $('#comment-toast').removeClass('bg-success').addClass('bg-danger');
                    let toast = new bootstrap.Toast(document.getElementById('comment-toast'));
                    toast.show();
                }
            });
        });
    });
</script>
@endsection

