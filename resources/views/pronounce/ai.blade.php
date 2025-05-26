<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luyện Nói Tiếng Anh (VSTEP)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        // Add this to make CSRF token available globally
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #4a5568;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 101, 101, 0.4);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .prompt-content {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .prompt-item {
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .prompt-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .prompt-label {
            font-weight: 600;
            color: #4a5568;
            margin-right: 10px;
        }

        .sample-content {
            background: linear-gradient(135deg, #fff5f5, #fed7d7);
            padding: 25px;
            border-radius: 15px;
            border-left: 4px solid #f56565;
            line-height: 1.6;
        }

        .recording-controls {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 25px;
            padding: 20px;
            background: rgba(0,0,0,0.05);
            border-radius: 15px;
        }

        .score-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .score-item {
            background: linear-gradient(135deg, #e6fffa, #b2f5ea);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid rgba(56, 178, 172, 0.2);
        }

        .score-value {
            font-size: 2rem;
            font-weight: 700;
            color: #319795;
            margin-bottom: 5px;
        }

        .score-label {
            font-size: 0.9rem;
            color: #4a5568;
            font-weight: 600;
        }

        .feedback-section {
            background: linear-gradient(135deg, #fffbf0, #fef5e7);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #ed8936;
        }

        .feedback-item {
            margin-bottom: 15px;
        }

        .feedback-label {
            font-weight: 600;
            color: #744210;
            margin-bottom: 8px;
            display: block;
        }

        .corrections-section {
            background: linear-gradient(135deg, #f0fff4, #c6f6d5);
            padding: 25px;
            border-radius: 15px;
            border-left: 4px solid #48bb78;
        }

        .error-list {
            list-style: none;
            padding: 0;
        }

        .error-item {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            border-left: 3px solid #f56565;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .error-type {
            font-weight: 600;
            color: #e53e3e;
            margin-bottom: 5px;
        }

        .error-correction {
            color: #38a169;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .error-explanation {
            color: #4a5568;
            font-style: italic;
        }

        .hidden {
            display: none;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .recording-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            background: #f56565;
            border-radius: 50%;
            animation: pulse 1s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            border-left: 4px solid;
        }

        .alert-error {
            background: #fed7d7;
            border-left-color: #f56565;
            color: #c53030;
        }

        .alert-info {
            background: #bee3f8;
            border-left-color: #3182ce;
            color: #2b6cb0;
        }

        .corrected-text {
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .error {
            color: red;
            text-decoration: line-through;
        }

        .correction {
            color: green;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .card {
                padding: 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .recording-controls {
                flex-direction: column;
                align-items: center;
            }
            
            .score-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-microphone-alt"></i> Luyện Nói Tiếng Anh (VSTEP)</h1>
            <p>Nâng cao kỹ năng Speaking với AI đánh giá chính xác</p>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="fas fa-cog"></i>
                Cài đặt bài tập
            </div>
            <form id="promptForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="topic" class="form-label">
                            <i class="fas fa-lightbulb"></i> Chủ đề (tùy chọn)
                        </label>
                        <input type="text" id="topic" name="topic" class="form-control" 
                               placeholder="Nhập chủ đề (ví dụ: Education, Technology)">
                    </div>
                    <div class="form-group">
                        <label for="level" class="form-label">
                            <i class="fas fa-chart-line"></i> Trình độ
                        </label>
                        <select id="level" name="level" class="form-control">
                            <option value="A1">A1 - Sơ cấp</option>
                            <option value="A2">A2 - Cơ bản</option>
                            <option value="B1" selected>B1 - Trung cấp</option>
                            <option value="B2">B2 - Trung cấp cao</option>
                            <option value="C1">C1 - Cao cấp</option>
                            <option value="C2">C2 - Thành thạo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="task_type" class="form-label">
                            <i class="fas fa-tasks"></i> Loại bài nói
                        </label>
                        <select id="task_type" name="task_type" class="form-control">
                            <option value="Social Interaction" selected>Social Interaction (Tương tác xã hội)</option>
                            <option value="Solution Discussion">Solution Discussion (Thảo luận giải pháp)</option>
                            <option value="Topic Development">Topic Development (Phát triển chủ đề)</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-magic"></i>
                    <span class="btn-text">Tạo đề bài</span>
                </button>
            </form>
        </div>

        <div id="promptResult" class="card hidden">
            <div class="card-title">
                <i class="fas fa-file-alt"></i>
                Đề bài của bạn
            </div>
            <div class="prompt-content">
                <div id="promptContent"></div>
            </div>
            
            <div class="card-title">
                <i class="fas fa-star"></i>
                Bài mẫu tham khảo
            </div>
            <div class="sample-content">
                <div id="sampleContent"></div>
            </div>
            
            <div class="recording-controls">
                <button id="startRecording" class="btn btn-success">
                    <i class="fas fa-play"></i>
                    Bắt đầu ghi âm
                </button>
                <button id="stopRecording" class="btn btn-danger" disabled>
                    <span class="recording-indicator"></span>
                    Dừng ghi âm
                </button>
            </div>
        </div>

        <div id="evaluationResult" class="card hidden">
            <div class="card-title">
                <i class="fas fa-chart-bar"></i>
                Kết quả đánh giá
            </div>
            
            <div class="score-grid" id="scores"></div>
            
            <div class="feedback-section">
                <div class="card-title">
                    <i class="fas fa-comments"></i>
                    Nhận xét chi tiết
                </div>
                <div id="feedback"></div>
            </div>
            
            <div class="corrections-section">
                <div class="card-title">
                    <i class="fas fa-edit"></i>
                    Bài sửa và gợi ý
                </div>
                <div id="corrections"></div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let mediaRecorder;
        let audioChunks = [];
        let currentPromptData = null;
        let recognition = null;
        let transcribedText = '';

        // Setup CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Initialize Speech Recognition if available
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = 'en-US';
            
            recognition.onresult = function(event) {
                let finalTranscript = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    if (event.results[i].isFinal) {
                        finalTranscript += event.results[i][0].transcript;
                    }
                }
                if (finalTranscript) {
                    transcribedText += finalTranscript + ' ';
                }
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
            };
        }

        // Handle prompt generation
        document.getElementById('promptForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const btnText = submitBtn.querySelector('.btn-text');
            const originalText = btnText.textContent;
            
            // Show loading state
            btnText.innerHTML = '<span class="loading"></span> Đang tạo...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(this);
                const response = await fetch('/pronounce/generate-prompt', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Có lỗi xảy ra khi tạo đề bài');
                }

                // Store prompt data for evaluation
                currentPromptData = data.prompt;
                
                // Display prompt content
                document.getElementById('promptContent').innerHTML = `
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-heading"></i> Tiêu đề:</span>
                        ${data.prompt.title}
                    </div>
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-list-ul"></i> Hướng dẫn:</span>
                        ${data.prompt.instruction}
                    </div>
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-tag"></i> Chủ đề:</span>
                        ${data.prompt.topic}
                    </div>
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-layer-group"></i> Trình độ:</span>
                        ${data.prompt.level}
                    </div>
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-microphone"></i> Loại bài:</span>
                        ${data.prompt.task_type}
                    </div>
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-clock"></i> Thời gian chuẩn bị:</span>
                        ${data.prompt.preparation_time} giây
                    </div>
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-stopwatch"></i> Thời gian nói:</span>
                        ${data.prompt.speaking_time} giây
                    </div>
                    <div class="prompt-item">
                        <span class="prompt-label"><i class="fas fa-info-circle"></i> Lưu ý:</span>
                        ${data.prompt.notes}
                    </div>
                `;
                
                document.getElementById('sampleContent').innerHTML = data.sample.content;
                
                const promptResult = document.getElementById('promptResult');
                promptResult.classList.remove('hidden');
                promptResult.classList.add('fade-in');
                
                // Scroll to result
                promptResult.scrollIntoView({ behavior: 'smooth' });

            } catch (error) {
                showAlert('Có lỗi xảy ra: ' + error.message, 'error');
            } finally {
                // Reset button
                btnText.textContent = originalText;
                submitBtn.disabled = false;
            }
        });

        // Handle audio recording
        document.getElementById('startRecording').addEventListener('click', async function() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];
                transcribedText = '';
                
                mediaRecorder.start();
                
                // Start speech recognition if available
                if (recognition) {
                    recognition.start();
                }
                
                this.disabled = true;
                document.getElementById('stopRecording').disabled = false;
                
                showAlert('Đang ghi âm... Hãy nói theo đề bài đã cho.', 'info');

                mediaRecorder.ondataavailable = function(e) {
                    audioChunks.push(e.data);
                };
            } catch (error) {
                showAlert('Không thể truy cập microphone. Vui lòng kiểm tra quyền truy cập.', 'error');
            }
        });

        document.getElementById('stopRecording').addEventListener('click', async function() {
            if (!mediaRecorder) return;
            
            mediaRecorder.stop();
            
            // Stop speech recognition
            if (recognition) {
                recognition.stop();
            }
            
            this.disabled = true;
            document.getElementById('startRecording').disabled = false;

            mediaRecorder.onstop = async function() {
                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                audioChunks = [];

                // Show processing message
                showAlert('Đang phân tích và đánh giá bài nói của bạn...', 'info');

                try {
                    // If we don't have transcribed text from speech recognition, 
                    // we'll need to use a fallback or ask user to input text
                    if (!transcribedText.trim()) {
                        transcribedText = prompt('Chức năng nhận dạng giọng nói không khả dụng. Vui lòng nhập nội dung bài nói của bạn:') || '';
                    }

                    if (!transcribedText.trim()) {
                        throw new Error('Không có nội dung để đánh giá');
                    }

                    // Send for evaluation
                    await evaluateSpeaking(transcribedText.trim());
                    
                } catch (error) {
                    showAlert('Có lỗi xảy ra khi đánh giá: ' + error.message, 'error');
                }
            };
        });

        async function evaluateSpeaking(userText) {
            try {
                const response = await fetch('/pronounce/evaluate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        user_speaking_text: userText,
                        prompt_data: currentPromptData
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Có lỗi xảy ra khi đánh giá');
                }

                displayEvaluationResults(data);

            } catch (error) {
                throw error;
            }
        }

        function displayEvaluationResults(evaluation) {
            // Display scores
            document.getElementById('scores').innerHTML = `
                <div class="score-item">
                    <div class="score-value">${evaluation.scores.pronunciation}</div>
                    <div class="score-label">Phát âm</div>
                </div>
                <div class="score-item">
                    <div class="score-value">${evaluation.scores.fluency}</div>
                    <div class="score-label">Độ trôi chảy</div>
                </div>
                <div class="score-item">
                    <div class="score-value">${evaluation.scores.vocabulary}</div>
                    <div class="score-label">Từ vựng</div>
                </div>
                <div class="score-item">
                    <div class="score-value">${evaluation.scores.grammar}</div>
                    <div class="score-label">Ngữ pháp</div>
                </div>
                <div class="score-item" style="grid-column: span 2;">
                    <div class="score-value" style="font-size: 2.5rem; color: #667eea;">${evaluation.scores.total}</div>
                    <div class="score-label" style="font-size: 1.1rem;">Tổng điểm</div>
                </div>
            `;

            // Display feedback
            document.getElementById('feedback').innerHTML = `
                <div class="feedback-item">
                    <span class="feedback-label"><i class="fas fa-comment-alt"></i> Nhận xét chung:</span>
                    ${evaluation.feedback.general}
                </div>
                <div class="feedback-item">
                    <span class="feedback-label"><i class="fas fa-thumbs-up"></i> Điểm mạnh:</span>
                    ${evaluation.feedback.strengths.join(', ')}
                </div>
                <div class="feedback-item">
                    <span class="feedback-label"><i class="fas fa-exclamation-triangle"></i> Điểm yếu:</span>
                    ${evaluation.feedback.weaknesses.join(', ')}
                </div>
                <div class="feedback-item">
                    <span class="feedback-label"><i class="fas fa-lightbulb"></i> Gợi ý cải thiện:</span>
                    ${evaluation.feedback.suggestions}
                </div>
            `;

            // Display corrections
            const errorsHtml = evaluation.corrections.detailed_errors.map(error => `
                <li class="error-item">
                    <div class="error-type"><i class="fas fa-times-circle"></i> ${error.error}</div>
                    <div class="error-correction"><i class="fas fa-check-circle"></i> ${error.correction}</div>
                    <div class="error-explanation"><i class="fas fa-info-circle"></i> ${error.explanation}</div>
                </li>
            `).join('');

            document.getElementById('corrections').innerHTML = `
                <div class="feedback-item">
                    <span class="feedback-label"><i class="fas fa-file-alt"></i> Bài sửa:</span>
                    <div class="corrected-text">${evaluation.corrections.corrected_text}</div>
                </div>
                <div class="feedback-item">
                    <span class="feedback-label"><i class="fas fa-list"></i> Chi tiết lỗi:</span>
                    <ul class="error-list">${errorsHtml}</ul>
                </div>
            `;

            const evaluationResult = document.getElementById('evaluationResult');
            evaluationResult.classList.remove('hidden');
            evaluationResult.classList.add('fade-in');
            evaluationResult.scrollIntoView({ behavior: 'smooth' });
            
            // Remove processing alert
            removeAlerts();
        }

        function showAlert(message, type) {
            removeAlerts();
            
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i> ${message}`;
            
            document.querySelector('.container').insertBefore(alert, document.querySelector('.card'));
        }

        function removeAlerts() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => alert.remove());
        }
    </script>
</body>
</html>
