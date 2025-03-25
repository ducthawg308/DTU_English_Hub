@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">✍️ Viết blog mới</h2>

        <form action="{{ route('store.community') }}" method="POST">
            @csrf

            <!-- Tiêu đề -->
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề bài viết</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề..." required>
            </div>

            <!-- Nội dung (CKEditor) -->
            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea class="form-control" id="content" name="content" rows="10" placeholder="Nhập nội dung blog..."></textarea>
            </div>

            <!-- Nút submit -->
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="fa-solid fa-paper-plane me-2"></i> Đăng bài
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {
                height: '400px'
            })
            .then(editor => {
                editor.ui.view.editable.element.style.minHeight = '400px';
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection