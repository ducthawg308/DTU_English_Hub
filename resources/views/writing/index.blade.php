@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Luyện tập Writing</h1>
    
    <!-- Phần chọn độ khó và loại task -->
    <div class="row mb-4" id="selection-section">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Độ khó</h5>
                </div>
                <div class="card-body">
                    @php
                        $levelValue = old('level', $level ?? 'A1');
                    @endphp

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="level" id="levelA1" value="A1" {{ $levelValue == 'A1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="levelA1">A1 - Cơ bản tối thiểu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="level" id="levelA2" value="A2" {{ $levelValue == 'A2' ? 'checked' : '' }}>
                        <label class="form-check-label" for="levelA2">A2 - Sơ cấp</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="level" id="levelB1" value="B1" {{ $levelValue == 'B1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="levelB1">B1 - Trung cấp</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="level" id="levelB2" value="B2" {{ $levelValue == 'B2' ? 'checked' : '' }}>
                        <label class="form-check-label" for="levelB2">B2 - Trên trung cấp</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="level" id="levelC1" value="C1" {{ $levelValue == 'C1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="levelC1">C1 - Cao cấp</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="level" id="levelC2" value="C2" {{ $levelValue == 'C2' ? 'checked' : '' }}>
                        <label class="form-check-label" for="levelC2">C2 - Thành thạo</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Loại bài viết</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="radio" name="task_type" id="taskEmail" value="email" checked>
                        <label class="form-check-label" for="taskEmail">
                            <strong>Task 1: Email / Letter</strong>
                            <p class="text-muted mb-0">Informal/Formal - Viết email hoặc thư cho người quen hoặc đơn vị chính thức</p>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="task_type" id="taskEssay" value="essay">
                        <label class="form-check-label" for="taskEssay">
                            <strong>Task 2: Essay</strong>
                            <p class="text-muted mb-0">Opinion, Problem-Solution, Advantage/Disadvantage - Viết luận về một vấn đề</p>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Phần nhập chủ đề -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Chủ đề (tùy chọn)</h5>
        </div>
        <div class="card-body">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ old('topic', $topic ?? '') }}" id="topic" placeholder="Nhập chủ đề">
                <label for="topic">Nhập chủ đề bạn muốn viết (để trống nếu muốn chọn ngẫu nhiên)</label>
            </div>
            <button id="generate-prompt-btn" class="btn btn-primary">
                <i class="fas fa-cogs me-2"></i>Tạo đề bài
            </button>
        </div>
    </div>
    
    <!-- Khu vực hiển thị đề bài -->
    <div id="prompt-section" class="card mb-4" style="display: none;">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Đề bài Writing</h5>
        </div>
        <div class="card-body">
            <div id="prompt-loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Đang tạo đề bài...</p>
            </div>
            
            <div id="prompt-content" style="display: none;">
                <div class="mb-3">
                    <span id="prompt-level" class="badge bg-primary me-2"></span>
                    <span id="prompt-task-type" class="badge bg-success me-2"></span>
                    <span id="prompt-topic" class="badge bg-info"></span>
                </div>
                <h4 id="prompt-title" class="mb-3"></h4>
                <div id="prompt-instruction" class="alert alert-light border mb-3"></div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="text-muted">
                            <i class="fas fa-clock me-1"></i>Thời gian đề xuất: <span id="prompt-time"></span> phút
                        </span>
                        <span class="ms-3 text-muted">
                            <i class="fas fa-text-width me-1"></i>Số từ đề xuất: <span id="prompt-word-count"></span> từ
                        </span>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row gap-2">
                    <button id="show-sample-btn" class="btn btn-outline-primary flex-grow-1">
                        <i class="fas fa-eye me-2"></i>Bài mẫu
                    </button>
                    <button id="write-myself-btn" class="btn btn-success flex-grow-1">
                        <i class="fas fa-pencil-alt me-2"></i>Tự viết
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Khu vực hiển thị bài mẫu -->
    <div id="sample-section" class="card mb-4" style="display: none;">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bài viết mẫu</h5>
            <button id="close-sample-btn" class="btn btn-sm btn-light">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="card-body">
            <div id="sample-content"></div>
            <div class="mt-3 text-muted">
                <i class="fas fa-text-width me-1"></i>Số từ: <span id="sample-word-count"></span>
            </div>
            <div class="mt-3">
                <button id="write-after-sample-btn" class="btn btn-primary">
                    <i class="fas fa-pencil-alt me-2"></i>Bây giờ tôi muốn tự viết
                </button>
            </div>
        </div>
    </div>
    
    <!-- Khu vực viết bài -->
    <div id="writing-section" class="card mb-4" style="display: none;">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Viết bài của bạn</h5>
        </div>
        <div class="card-body">
            <div id="writing-prompt-reminder" class="alert alert-light border mb-3"></div>
            
            <div class="form-floating mb-3">
                <textarea class="form-control" id="user-writing" style="height: 300px"></textarea>
                <label for="user-writing">Viết bài của bạn tại đây</label>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <div id="word-counter" class="text-muted">
                    <i class="fas fa-text-width me-1"></i>Số từ: 0
                </div>
                <button id="submit-writing-btn" class="btn btn-primary">
                    <i class="fas fa-check-circle me-2"></i>Nộp bài để được chấm điểm
                </button>
            </div>
        </div>
    </div>
    
    <!-- Khu vực phản hồi đánh giá -->
    <div id="feedback-section" class="card mb-4" style="display: none;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Đánh giá bài viết</h5>
        </div>
        <div class="card-body">
            <div id="feedback-loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Đang đánh giá bài viết...</p>
            </div>
            
            <div id="feedback-content" style="display: none;">
                <!-- Điểm số -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h4 class="card-title">Điểm tổng</h4>
                                <div id="total-score" class="display-4 fw-bold text-primary"></div>
                                <p class="text-muted">Trên thang 10</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Điểm thành phần</h5>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span>Nội dung:</span>
                                            <span id="content-score" class="fw-bold"></span>
                                        </div>
                                        <div class="progress mb-3">
                                            <div id="content-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10"></div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between">
                                            <span>Ngữ pháp:</span>
                                            <span id="grammar-score" class="fw-bold"></span>
                                        </div>
                                        <div class="progress">
                                            <div id="grammar-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10"></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span>Từ vựng:</span>
                                            <span id="vocabulary-score" class="fw-bold"></span>
                                        </div>
                                        <div class="progress mb-3">
                                            <div id="vocabulary-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10"></div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between">
                                            <span>Cấu trúc:</span>
                                            <span id="structure-score" class="fw-bold"></span>
                                        </div>
                                        <div class="progress">
                                            <div id="structure-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Nhận xét -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Nhận xét chung</h5>
                    </div>
                    <div class="card-body">
                        <p id="general-feedback"></p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6 class="text-success mb-2"><i class="fas fa-check-circle me-2"></i>Điểm mạnh</h6>
                                <ul id="strengths-list" class="list-group list-group-flush"></ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-danger mb-2"><i class="fas fa-exclamation-circle me-2"></i>Điểm yếu</h6>
                                <ul id="weaknesses-list" class="list-group list-group-flush"></ul>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h6 class="text-primary mb-2"><i class="fas fa-lightbulb me-2"></i>Gợi ý cải thiện</h6>
                            <p id="suggestions-feedback"></p>
                        </div>
                    </div>
                </div>
                
                <!-- Bài viết có đánh dấu lỗi -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Bài viết của bạn (có đánh dấu lỗi)</h5>
                    </div>
                    <div class="card-body">
                        <div id="corrected-text" class="border p-3 rounded"></div>
                    </div>
                </div>
                
                <!-- Danh sách lỗi chi tiết -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Danh sách lỗi chi tiết</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Lỗi</th>
                                        <th width="20%">Sửa thành</th>
                                        <th width="60%">Giải thích</th>
                                    </tr>
                                </thead>
                                <tbody id="errors-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="d-flex flex-column flex-md-row gap-2">
                    <button id="try-again-btn" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-redo me-2"></i>Viết lại bài này
                    </button>
                    <button id="new-prompt-btn" class="btn btn-outline-primary flex-grow-1">
                        <i class="fas fa-plus-circle me-2"></i>Tạo đề bài mới
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript để xử lý logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Các biến lưu trữ dữ liệu
    let promptData = null;
    
    // Nút tạo đề bài
    document.getElementById('generate-prompt-btn').addEventListener('click', function() {
        console.log('Generate prompt button clicked');
        // Lấy các giá trị đã chọn
        const level = document.querySelector('input[name="level"]:checked').value;
        const taskType = document.querySelector('input[name="task_type"]:checked').value;
        const topic = document.getElementById('topic').value.trim();
        
        // Hiển thị section đề bài và trạng thái loading
        document.getElementById('prompt-section').style.display = 'block';
        document.getElementById('prompt-loading').style.display = 'block';
        document.getElementById('prompt-content').style.display = 'none';
        
        // Cuộn đến phần đề bài
        document.getElementById('prompt-section').scrollIntoView({behavior: 'smooth'});
        
        // Gọi API để lấy đề bài
        fetch('/writing/generate-prompt', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                level: level,
                task_type: taskType,
                topic: topic
            })
        })
        .then(response => response.json())
        .then(data => {
            // Lưu dữ liệu đề bài
            promptData = data.prompt;
            
            // Cập nhật nội dung
            // Continue from where the code was cut off in paste.txt
            // Hiển thị thông tin đề bài
            document.getElementById('prompt-level').textContent = promptData.level;
            document.getElementById('prompt-task-type').textContent = 
                promptData.task_type === 'email' ? 'Email/Letter' : 'Essay';
            document.getElementById('prompt-topic').textContent = promptData.topic;
            document.getElementById('prompt-title').textContent = promptData.title;
            document.getElementById('prompt-instruction').innerHTML = promptData.instruction;
            document.getElementById('prompt-time').textContent = promptData.time_suggested;
            document.getElementById('prompt-word-count').textContent = promptData.suggested_word_count;
            
            // Ẩn loading, hiển thị nội dung
            document.getElementById('prompt-loading').style.display = 'none';
            document.getElementById('prompt-content').style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('prompt-loading').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Có lỗi xảy ra khi tạo đề bài. Vui lòng thử lại!
                </div>
            `;
        });
    });
    
    // Nút hiển thị bài mẫu
    document.getElementById('show-sample-btn').addEventListener('click', function() {
        if (promptData && promptData.sample) {
            document.getElementById('sample-content').innerHTML = promptData.sample.content;
            document.getElementById('sample-word-count').textContent = promptData.sample.word_count;
            document.getElementById('sample-section').style.display = 'block';
            document.getElementById('sample-section').scrollIntoView({behavior: 'smooth'});
        }
    });
    
    // Nút đóng bài mẫu
    document.getElementById('close-sample-btn').addEventListener('click', function() {
        document.getElementById('sample-section').style.display = 'none';
    });
    
    // Nút tự viết bài (từ phần đề bài)
    document.getElementById('write-myself-btn').addEventListener('click', function() {
        showWritingSection();
    });
    
    // Nút tự viết bài (sau khi đã xem bài mẫu)
    document.getElementById('write-after-sample-btn').addEventListener('click', function() {
        showWritingSection();
    });
    
    // Hàm hiển thị phần viết bài
    function showWritingSection() {
        // Hiển thị phần viết bài
        document.getElementById('writing-section').style.display = 'block';
        
        // Hiển thị lại đề bài trong phần viết bài
        document.getElementById('writing-prompt-reminder').innerHTML = `
            <strong>${promptData.title}</strong>
            <p>${promptData.instruction}</p>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <span class="badge bg-primary">${promptData.level}</span>
                <span class="badge bg-success">${promptData.task_type === 'email' ? 'Email/Letter' : 'Essay'}</span>
                <span class="badge bg-info">${promptData.topic}</span>
                <span class="badge bg-secondary"><i class="fas fa-text-width me-1"></i>${promptData.suggested_word_count} từ</span>
            </div>
        `;
        
        // Đặt focus vào textarea
        document.getElementById('user-writing').focus();
        
        // Cuộn đến phần viết bài
        document.getElementById('writing-section').scrollIntoView({behavior: 'smooth'});
    }
    
    // Đếm từ trong textarea
    document.getElementById('user-writing').addEventListener('input', function() {
        const text = this.value;
        const wordCount = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
        document.getElementById('word-counter').innerHTML = `<i class="fas fa-text-width me-1"></i>Số từ: ${wordCount}`;
    });
    
    // Nút nộp bài để chấm điểm
    document.getElementById('submit-writing-btn').addEventListener('click', function() {
        const userWriting = document.getElementById('user-writing').value.trim();
        
        if (userWriting === '') {
            alert('Vui lòng viết bài trước khi nộp!');
            return;
        }
        
        // Hiển thị phần đánh giá và trạng thái loading
        document.getElementById('feedback-section').style.display = 'block';
        document.getElementById('feedback-loading').style.display = 'block';
        document.getElementById('feedback-content').style.display = 'none';
        
        // Cuộn đến phần đánh giá
        document.getElementById('feedback-section').scrollIntoView({behavior: 'smooth'});
        
        // Gọi API để đánh giá bài viết
        fetch('/writing/evaluate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_writing: userWriting,
                prompt_data: promptData
            })
        })
        .then(response => response.json())
        .then(data => {
            // Cập nhật điểm số
            document.getElementById('total-score').textContent = data.scores.total;
            
            document.getElementById('content-score').textContent = data.scores.content;
            document.getElementById('grammar-score').textContent = data.scores.grammar;
            document.getElementById('vocabulary-score').textContent = data.scores.vocabulary;
            document.getElementById('structure-score').textContent = data.scores.structure;
            
            // Cập nhật thanh tiến trình
            document.getElementById('content-progress').style.width = `${data.scores.content * 10}%`;
            document.getElementById('grammar-progress').style.width = `${data.scores.grammar * 10}%`;
            document.getElementById('vocabulary-progress').style.width = `${data.scores.vocabulary * 10}%`;
            document.getElementById('structure-progress').style.width = `${data.scores.structure * 10}%`;
            
            // Cập nhật phần feedback
            document.getElementById('general-feedback').textContent = data.feedback.general;
            
            // Điểm mạnh
            const strengthsList = document.getElementById('strengths-list');
            strengthsList.innerHTML = '';
            data.feedback.strengths.forEach(strength => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = strength;
                strengthsList.appendChild(li);
            });
            
            // Điểm yếu
            const weaknessesList = document.getElementById('weaknesses-list');
            weaknessesList.innerHTML = '';
            data.feedback.weaknesses.forEach(weakness => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = weakness;
                weaknessesList.appendChild(li);
            });
            
            // Gợi ý cải thiện
            document.getElementById('suggestions-feedback').textContent = data.feedback.suggestions;
            
            // Bài viết đã sửa lỗi
            document.getElementById('corrected-text').innerHTML = data.corrections.corrected_text;
            
            // Danh sách lỗi chi tiết
            const errorsTableBody = document.getElementById('errors-table-body');
            errorsTableBody.innerHTML = '';
            data.corrections.detailed_errors.forEach(error => {
                const row = document.createElement('tr');
                
                const errorCell = document.createElement('td');
                errorCell.textContent = error.error;
                row.appendChild(errorCell);
                
                const correctionCell = document.createElement('td');
                correctionCell.textContent = error.correction;
                row.appendChild(correctionCell);
                
                const explanationCell = document.createElement('td');
                explanationCell.textContent = error.explanation;
                row.appendChild(explanationCell);
                
                errorsTableBody.appendChild(row);
            });
            
            // Ẩn loading, hiển thị nội dung
            document.getElementById('feedback-loading').style.display = 'none';
            document.getElementById('feedback-content').style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('feedback-loading').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Có lỗi xảy ra khi đánh giá bài viết. Vui lòng thử lại!
                </div>
            `;
        });
    });
    
    // Nút viết lại bài
    document.getElementById('try-again-btn').addEventListener('click', function() {
        // Cuộn đến phần viết bài
        document.getElementById('writing-section').scrollIntoView({behavior: 'smooth'});
        document.getElementById('user-writing').focus();
    });
    
    // Nút tạo đề bài mới
    document.getElementById('new-prompt-btn').addEventListener('click', function() {
        // Reset UI
        document.getElementById('sample-section').style.display = 'none';
        document.getElementById('writing-section').style.display = 'none';
        document.getElementById('feedback-section').style.display = 'none';
        document.getElementById('prompt-section').style.display = 'none';
        document.getElementById('user-writing').value = '';
        document.getElementById('word-counter').innerHTML = '<i class="fas fa-text-width me-1"></i>Số từ: 0';
        
        // Cuộn lên phần chọn độ khó
        document.getElementById('selection-section').scrollIntoView({behavior: 'smooth'});
    });
});
</script>
@endsection