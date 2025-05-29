@extends('layouts.app')

@section('content')
<div class="container px-4 py-5" style="min-height: 80vh;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-6 fw-bold text-primary">Tạo bài đọc từ AI</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">DTU English Hub</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tạo bài đọc từ AI</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-3 mb-5">
        <div class="card-header bg-primary bg-gradient text-white py-3">
            <h5 class="mb-0"><i class="fas fa-pen-fancy me-2"></i>Tùy chỉnh bài đọc</h5>
        </div>
        <div class="card-body p-4">
            <form id="ai-form" class="row g-3">
                @csrf
                @php
                    $availableTopics = ['Environment', 'Technology', 'Sports', 'Education', 'Health', 'Culture', 'Travel'];
                    $isCustomTopic = isset($topic) && !in_array($topic, $availableTopics);
                @endphp

                <div class="col-md-12">
                    <label for="topic" class="form-label fw-bold">Chủ đề bài đọc</label>

                    <!-- Select chế độ -->
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-light"><i class="fas fa-tag"></i></span>
                        <select class="form-select" id="topic-mode" name="topic-mode">
                            <option value="select" @selected(!$isCustomTopic)>Chọn từ danh sách</option>
                            <option value="input" @selected($isCustomTopic)>Tự nhập chủ đề</option>
                        </select>
                    </div>

                    <!-- Chọn từ danh sách -->
                    <div id="topic-select-container" class="input-group {{ $isCustomTopic ? 'd-none' : '' }}">
                        <span class="input-group-text bg-light"><i class="fas fa-list"></i></span>
                        <select class="form-select" id="topic-select" name="topic">
                            <option value="">-- Chọn chủ đề --</option>
                            @foreach ($availableTopics as $t)
                                <option value="{{ $t }}" @selected(isset($topic) && $topic === $t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tự nhập chủ đề -->
                    <div id="topic-input-container" class="input-group {{ $isCustomTopic ? '' : 'd-none' }}">
                        <span class="input-group-text bg-light"><i class="fas fa-tag"></i></span>
                        <input type="text" class="form-control" id="topic-input" name="topic"
                            value="{{ $isCustomTopic ? $topic : '' }}"
                            placeholder="Nhập chủ đề bạn muốn đọc (VD: Environment, Technology, Sports...)">
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="word_count" class="form-label fw-bold">Độ dài bài đọc</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-text-width"></i></span>
                        <input type="range" class="form-range form-control" id="word-range" min="100" max="500" step="50" value="250">
                        <input type="number" class="form-control" id="word_count" name="word_count" 
                            min="100" max="500" value="250" required>
                        <span class="input-group-text">từ</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="level" class="form-label fw-bold">Cấp độ</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-graduation-cap"></i></span>
                        <select class="form-select" id="level" name="level" required>
                            <option value="">-- Chọn cấp độ --</option>
                            <option value="A1" @selected($level == 'A1')>A1 - Beginner (Sơ cấp)</option>
                            <option value="A2" @selected($level == 'A2')>A2 - Elementary (Tiền cơ bản)</option>
                            <option value="B1" @selected($level == 'B1')>B1 - Intermediate (Trung cấp)</option>
                            <option value="B2" @selected($level == 'B2')>B2 - Upper Intermediate (Cao trung cấp)</option>
                            <option value="C1" @selected($level == 'C1')>C1 - Advanced (Nâng cao)</option>
                            <option value="C2" @selected($level == 'C2')>C2 - Proficiency (Thành thạo)</option>

                        </select>
                    </div>
                    <div class="form-text">Chọn cấp độ phù hợp với trình độ của bạn</div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2">
                        <i class="fas fa-magic me-2"></i>Tạo bài đọc
                    </button>
                    <div id="loading" class="d-none mt-3">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-primary me-3" role="status">
                                <span class="visually-hidden">Đang tạo...</span>
                            </div>
                            <span class="fw-bold">Đang tạo bài đọc... Vui lòng đợi trong giây lát</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reading Result Section -->
    <div id="reading-result" class="mb-5"></div>
    
    <!-- Questions Section -->
    <div id="question-result" class="mb-5"></div>
    
    <div id="action-buttons" class="text-center mb-5 d-none">
        <button id="print-reading" class="btn btn-outline-secondary me-2">
            <i class="fas fa-print me-2"></i>In bài đọc
        </button>
    </div>

</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Custom Styles */
    .reading-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #333;
        text-align: justify;
    }
    
    .reading-content p {
        margin-bottom: 1.5rem;
    }
    
    .reading-title {
        font-size: 1.8rem;
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .reading-info {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .reading-info .badge {
        margin-right: 10px;
        padding: 6px 12px;
        font-size: 0.85rem;
    }
    
    .question-card {
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        border: none;
    }
    
    .question-header {
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .question-body {
        padding: 20px;
    }
    
    .form-check {
        padding: 12px 12px 12px 40px;
        border-radius: 6px;
        margin-bottom: 8px;
        transition: background-color 0.2s;
    }
    
    .form-check:hover {
        background-color: #f8f9fa;
    }
    
    .form-check-input {
        margin-top: 0.3rem;
    }
    
    .form-check-label {
        cursor: pointer;
    }
    
    .answer-feedback {
        padding: 10px 15px;
        border-radius: 6px;
        margin-top: 15px;
    }
    
    .answer-correct {
        background-color: rgba(25, 135, 84, 0.1);
    }
    
    .answer-incorrect {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    #word-range {
        padding: 0.375rem 0.75rem;
    }
    
    .questions-section-title {
        position: relative;
        text-align: center;
        margin: 3rem 0 2rem;
    }
    
    .questions-section-title:after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: -10px;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background-color: #0d6efd;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let generatedReading = null;
        
        // Sync range and number input for word count
        const wordRange = document.getElementById('word-range');
        const wordCount = document.getElementById('word_count');
        
        wordRange.addEventListener('input', function() {
            wordCount.value = this.value;
        });
        
        wordCount.addEventListener('input', function() {
            wordRange.value = this.value;
        });

        // Handle topic mode switching
        const topicMode = document.getElementById('topic-mode');
        const topicSelectContainer = document.getElementById('topic-select-container');
        const topicInputContainer = document.getElementById('topic-input-container');
        const topicSelect = document.getElementById('topic-select');
        const topicInput = document.getElementById('topic-input');

        topicMode.addEventListener('change', function() {
            if (this.value === 'select') {
                topicSelectContainer.classList.remove('d-none');
                topicInputContainer.classList.add('d-none');
                topicSelect.name = 'topic';
                topicInput.name = '';
            } else {
                topicSelectContainer.classList.add('d-none');
                topicInputContainer.classList.remove('d-none');
                topicSelect.name = '';
                topicInput.name = 'topic';
            }
        });
    
        // Form submission
        document.getElementById('ai-form').addEventListener('submit', function(event) {
            event.preventDefault();
    
            let topic;
            if (topicMode.value === 'select') {
                topic = topicSelect.value;
            } else {
                topic = topicInput.value.trim();
            }
            let wordCount = document.getElementById('word_count').value;
            let level = document.getElementById('level').value;
            let loading = document.getElementById('loading');
            let resultContainer = document.getElementById('reading-result');
            let questionContainer = document.getElementById('question-result');
            let actionButtons = document.getElementById('action-buttons');
    
            if (!topic || !level || wordCount < 100 || wordCount > 500) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông tin không đầy đủ',
                    text: 'Vui lòng nhập/chọn chủ đề, chọn cấp độ và độ dài hợp lệ (100-500 từ).',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
    
            loading.classList.remove('d-none');
            loading.classList.add('d-flex');
            resultContainer.innerHTML = '';
            questionContainer.innerHTML = '';
            actionButtons.classList.add('d-none');
    
            let formData = new FormData();
            formData.append('topic', topic);
            formData.append('word_count', wordCount);
            formData.append('level', level);
            formData.append('_token', '{{ csrf_token() }}');
    
            fetch('{{ route("generate.reading") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                loading.classList.add('d-none');
                loading.classList.remove('d-flex');
    
                if (data.error) {
                    resultContainer.innerHTML = `
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> Lỗi: ${data.error}
                        </div>`;
                    return;
                }
    
                generatedReading = data;
                
                // Show Reading Section
                let levelBadgeClass = getLevelBadgeClass(level);
                let readingHtml = `
                    <div class="card shadow border-0 rounded-3 mb-5">
                        <div class="card-body p-4">
                            <h2 class="reading-title">${data.reading.title}</h2>
                            <div class="reading-info">
                                <span class="badge ${levelBadgeClass}">${level}</span>
                                <span class="badge bg-light text-dark"><i class="fas fa-tag me-1"></i>${topic}</span>
                                <span class="badge bg-light text-dark"><i class="fas fa-clock me-1"></i>Reading Time: ~${Math.ceil(wordCount/200)} min</span>
                            </div>
                            <div class="reading-content">
                                ${data.reading.content}
                            </div>
                        </div>
                    </div>
                `;
                resultContainer.innerHTML = readingHtml;
                
                // Show Questions Section
                let questionsHtml = `<h3 class="questions-section-title">Câu hỏi đọc hiểu</h3>`;
                
                data.questions.forEach((question, index) => {
                    let optionsHtml = question.options.map((opt, i) => {
                        let optionLabel = String.fromCharCode(65 + i); // A, B, C, D
                        return `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question-${index}" id="option-${index}-${i}" value="${optionLabel}">
                                <label class="form-check-label" for="option-${index}-${i}">${opt}</label>
                            </div>
                        `;
                    }).join("");

                    questionsHtml += `
                        <div class="card question-card">
                            <div class="question-header">
                                <h5 class="mb-0">Câu hỏi ${index + 1}</h5>
                            </div>
                            <div class="question-body">
                                <p class="fw-bold mb-3">${question.question}</p>
                                <div class="options-container mb-3">
                                    ${optionsHtml}
                                </div>
                                <button class="btn btn-primary check-answer" data-index="${index}" data-answer="${question.answer}">
                                    <i class="fas fa-check-circle me-2"></i>Kiểm tra đáp án
                                </button>
                                <div class="answer-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    `;
                });
    
                questionContainer.innerHTML = questionsHtml;
                actionButtons.classList.remove('d-none');

                // Answer checking functionality
                document.querySelectorAll('.check-answer').forEach(button => {
                    button.addEventListener('click', function() {
                        let index = this.getAttribute('data-index');
                        let correctAnswer = this.getAttribute('data-answer');
                        let selectedOption = document.querySelector(`input[name="question-${index}"]:checked`);
                        let feedback = this.nextElementSibling;

                        if (!selectedOption) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Chưa chọn đáp án',
                                text: 'Vui lòng chọn một đáp án trước khi kiểm tra.',
                                confirmButtonColor: '#3085d6'
                            });
                            return;
                        }

                        let correctOptionLabel = String.fromCharCode(64 + parseInt(correctAnswer.charCodeAt(0) - 64)); // Convert A, B, C, D to 1, 2, 3, 4
                        let selectedValue = selectedOption.value;
                        
                        if (selectedValue === correctAnswer) {
                            feedback.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Chính xác! Đáp án đúng là ${correctAnswer}.</span>
                                </div>`;
                            feedback.classList.add('answer-correct');
                            feedback.classList.remove('answer-incorrect');
                            
                            // Highlight correct answer
                            document.getElementById(`option-${index}-${correctAnswer.charCodeAt(0) - 65}`).parentNode.style.backgroundColor = 'rgba(25, 135, 84, 0.1)';
                        } else {
                            feedback.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                    <span>Không đúng! Đáp án đúng là ${correctAnswer}.</span>
                                </div>`;
                            feedback.classList.add('answer-incorrect');
                            feedback.classList.remove('answer-correct');
                            
                            // Highlight correct and incorrect answers
                            document.getElementById(`option-${index}-${correctAnswer.charCodeAt(0) - 65}`).parentNode.style.backgroundColor = 'rgba(25, 135, 84, 0.1)';
                            selectedOption.parentNode.style.backgroundColor = 'rgba(220, 53, 69, 0.1)';
                        }
                        feedback.style.display = "block";
                    });
                });
                
                // Print functionality
                document.getElementById('print-reading').addEventListener('click', function() {
                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(`
                        <html>
                        <head>
                            <title>${data.reading.title} - Print Version</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>
                                body { font-family: Arial, sans-serif; padding: 20px; }
                                .reading-content { font-size: 14pt; line-height: 1.6; }
                                .reading-content p { margin-bottom: 15px; }
                                h1 { font-size: 18pt; margin-bottom: 10px; }
                                .meta { font-size: 12pt; color: #666; margin-bottom: 20px; }
                                @media print {
                                    .no-print { display: none; }
                                    a { text-decoration: none; color: black; }
                                }
                                .question { margin-top: 30px; page-break-inside: avoid; }
                                .options { margin-left: 20px; }
                                .student-info { font-size: 14pt; margin-bottom: 20px; }
                                .student-info label { display: inline-block; width: 100px; font-weight: bold; }
                                .student-info input { border: none; width: 300px; font-size: 14pt; }
                                @media print {
                                    .student-info input { background: none; }
                                }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="no-print text-end mb-3">
                                    <button onclick="window.print()" class="btn btn-primary">In đề Reading</button>
                                </div>

                                <div class="student-info">
                                    <label>Họ và tên:</label>
                                    <input type="text" value="........................................" readonly>
                                    <br>
                                    <label>MSSV:</label>
                                    <input type="text" value="........................................" readonly>
                                </div>
                                
                                <h1>${data.reading.title}</h1>
                                <div class="meta">
                                    <span>Topic: ${topic}</span> | 
                                    <span>Level: ${level}</span>
                                </div>
                                
                                <div class="reading-content">
                                    ${data.reading.content}
                                </div>
                                
                                <h2 style="margin-top: 40px; margin-bottom: 20px;">Comprehension Questions</h2>
                    `);
                    
                    data.questions.forEach((question, index) => {
                        printWindow.document.write(`
                            <div class="question">
                                <p><strong>${index + 1}. ${question.question}</strong></p>
                                <div class="options">
                        `);
                        
                        question.options.forEach((opt, i) => {
                            let optionLabel = String.fromCharCode(65 + i);
                            printWindow.document.write(`
                                <div>${opt}</div>
                            `);
                        });
                        
                        printWindow.document.write(`</div></div>`);
                    });
                    
                    printWindow.document.write(`
                            </div>
                        </body>
                        </html>
                    `);
                    printWindow.document.close();
                });
            })
            .catch(error => {
                loading.classList.add('d-none');
                loading.classList.remove('d-flex');
                resultContainer.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Lỗi: ${error.message}
                    </div>`;
            });
        });
        
        // Helper function to get badge class based on level
        function getLevelBadgeClass(level) {
            switch(level) {
                case 'A1': return 'bg-success';
                case 'A2': return 'bg-info';
                case 'B1': return 'bg-primary';
                case 'B2': return 'bg-warning text-dark';
                case 'C1': return 'bg-danger';
                case 'C2': return 'bg-dark';
                default: return 'bg-secondary';
            }
        }
    });
</script>

<!-- Add SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection