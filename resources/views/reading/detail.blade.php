@extends('layouts.app')

@section('content') 
    <div class="container">
        <div id="reading-result" class="mb-5 mt-5">
            <div class="card shadow border-0 rounded-3 mb-5">
                <div class="card-body p-4">
                    <h2 class="reading-title">{{ $reading->title }}</h2>
                    <div class="reading-info">
                        @php
                            $badgeClass = match($reading->level) {
                                'A1' => 'bg-success',
                                'A2' => 'bg-info',
                                'B1' => 'bg-primary',
                                'B2' => 'bg-warning text-dark',
                                'C1' => 'bg-danger',
                                'C2' => 'bg-dark',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $reading->level }}</span>
                        <span class="badge bg-light text-dark"><i class="fas fa-tag me-1"></i>{{ $reading->topic ?? 'Reading' }}</span>
                        <span class="badge bg-light text-dark"><i class="fas fa-clock me-1"></i>Reading Time: ~{{ ceil(str_word_count(strip_tags($reading->content)) / 200) }} min</span>
                    </div>
                    <div class="reading-content">
                        {!! $reading->content !!}
                    </div>
                </div>
            </div>
        </div>

        <div id="question-result" class="mb-5">
            <h3 class="questions-section-title">Câu hỏi đọc hiểu</h3>
            @foreach($questions as $index => $question)
                <div class="card question-card">
                    <div class="question-header">
                        <h5 class="mb-0">Câu hỏi {{ $index + 1 }}</h5>
                    </div>
                    <div class="question-body">
                        <p class="fw-bold mb-3">{{ $question->question }}</p>
                        <div class="options-container mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question-{{ $index }}" id="option-{{ $index }}-0" value="A">
                                <label class="form-check-label" for="option-{{ $index }}-0">{{ $question->option_a }}</label>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question-{{ $index }}" id="option-{{ $index }}-1" value="B">
                                <label class="form-check-label" for="option-{{ $index }}-1">{{ $question->option_b }}</label>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question-{{ $index }}" id="option-{{ $index }}-2" value="C">
                                <label class="form-check-label" for="option-{{ $index }}-2">{{ $question->option_c }}</label>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question-{{ $index }}" id="option-{{ $index }}-3" value="D">
                                <label class="form-check-label" for="option-{{ $index }}-3">{{ $question->option_d }}</label>
                            </div>
                        </div>
                        <button class="btn btn-primary check-answer" data-index="{{ $index }}" data-answer="{{ $question->answer }}">
                            <i class="fas fa-check-circle me-2"></i>Kiểm tra đáp án
                        </button>
                        <div class="answer-feedback" style="display: none;"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="action-buttons" class="text-center mb-5">
            <button id="print-reading" class="btn btn-outline-secondary me-2">
                <i class="fas fa-print me-2"></i>In bài đọc
            </button>
            <a href="{{ route('default.reading', $reading->level) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách bài đọc
            </a>
        </div>
    </div>

    <!-- Add styles -->
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

    <!-- JavaScript for functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                const readingTitle = document.querySelector('.reading-title').innerText;
                const readingContent = document.querySelector('.reading-content').innerHTML;
                
                // Create questions for print
                let questionsHtml = '';
                document.querySelectorAll('.question-card').forEach((card, index) => {
                    const questionText = card.querySelector('.fw-bold').innerText;
                    const options = Array.from(card.querySelectorAll('.form-check-label')).map(label => label.innerText);
                    
                    questionsHtml += `
                        <div class="question">
                            <p><strong>${index + 1}. ${questionText}</strong></p>
                            <div class="options">
                                ${options.map(opt => `<div>${opt}</div>`).join('')}
                            </div>
                        </div>
                    `;
                });
                
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>${readingTitle} - Print Version</title>
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
                            
                            <h1>${readingTitle}</h1>
                            <div class="meta">
                                <span>Level: {{ $reading->level }}</span>
                            </div>
                            
                            <div class="reading-content">
                                ${readingContent}
                            </div>
                            
                            <h2 style="margin-top: 40px; margin-bottom: 20px;">Comprehension Questions</h2>
                            ${questionsHtml}
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            });

            function calculateReadingTime($content) {
                $wordCount = str_word_count(strip_tags($content));
                return ceil($wordCount / 200); // Average reading speed of 200 words per minute
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection