<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luyện Nghe Tiếng Anh (VSTEP)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
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
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

        .required {
            color: #e53e3e;
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
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
            transform: translateY(-1px);
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 12px;
            background: rgba(79, 172, 254, 0.05);
            border-radius: 10px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .checkbox-item:hover {
            border-color: #4facfe;
            background: rgba(79, 172, 254, 0.1);
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
        }

        .radio-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            padding: 12px;
            background: rgba(79, 172, 254, 0.05);
            border-radius: 10px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .radio-item:hover {
            border-color: #4facfe;
            background: rgba(79, 172, 254, 0.1);
        }

        .radio-item input[type="radio"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
        }

        .radio-item input[type="radio"]:checked + label,
        .checkbox-item input[type="checkbox"]:checked + label {
            font-weight: 600;
            color: #2b6cb0;
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
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .number-input-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .number-input {
            width: 100px;
            text-align: center;
        }

        .custom-topic {
            margin-top: 15px;
            display: none;
        }

        .custom-topic.show {
            display: block;
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

        .alert-success {
            background: #c6f6d5;
            border-left-color: #48bb78;
            color: #2f855a;
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

        .generated-content {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #4facfe;
        }

        .test-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background: rgba(79, 172, 254, 0.1);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .info-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2b6cb0;
            margin-bottom: 5px;
        }

        .info-label {
            font-size: 0.9rem;
            color: #4a5568;
            font-weight: 600;
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
            
            .checkbox-group {
                grid-template-columns: 1fr;
            }
            
            .radio-group {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-headphones"></i> Luyện Nghe Tiếng Anh (VSTEP)</h1>
            <p>Nâng cao kỹ năng Listening với AI tạo đề theo chuẩn VSTEP</p>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="fas fa-cog"></i>
                Cài đặt đề luyện tập
            </div>
            <form id="listeningForm">
                <div class="form-grid">
                    <!-- Trình độ mong muốn (Bắt buộc) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-chart-line"></i> Trình độ mong muốn <span class="required">*</span>
                        </label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="level_a2" name="level" value="A2" {{ $level == 'A2' ? 'checked' : '' }} required>
                                <label for="level_a2">A2 - Cơ bản</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="level_b1" name="level" value="B1" {{ $level == 'B1' ? 'checked' : '' }} required>
                                <label for="level_b1">B1 - Trung cấp</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="level_b2" name="level" value="B2" {{ $level == 'B2' ? 'checked' : '' }} required>
                                <label for="level_b2">B2 - Trung cấp cao</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="level_c1" name="level" value="C1" {{ $level == 'C1' ? 'checked' : '' }} required>
                                <label for="level_c1">C1 - Cao cấp</label>
                            </div>
                        </div>
                    </div>

                    <!-- Số lượng câu hỏi -->
                    <div class="form-group">
                        <label for="question_count" class="form-label">
                            <i class="fas fa-list-ol"></i> Số lượng câu hỏi
                        </label>
                        <select id="question_count" name="question_count" class="form-control">
                            <option value="6">Đề luyện ngắn (6 câu)</option>
                            <option value="20" selected>Đề tiêu chuẩn (20 câu - đủ 3 part)</option>
                            <option value="custom">Tùy chỉnh số câu</option>
                        </select>
                        <div id="custom_count" class="custom-topic">
                            <div class="number-input-group">
                                <label>Số câu:</label>
                                <input type="number" name="custom_question_count" class="form-control number-input" min="1" max="50" value="10">
                            </div>
                            
                        </div>
                    </div>

                    <!-- Chủ đề mong muốn -->
                    @php
                        $defaultTopics = ['daily_communication', 'academic', 'workplace', 'travel', 'mixed'];
                        $isCustom = isset($topic) && !in_array($topic, $defaultTopics);
                    @endphp

                    <div class="form-group">
                        <label for="topic" class="form-label">
                            <i class="fas fa-lightbulb"></i> Chủ đề mong muốn
                        </label>
                        <select id="topic" name="topic" class="form-control">
                            <option value="daily_communication" {{ empty($topic) || $topic == 'daily_communication' ? 'selected' : '' }}>Giao tiếp hàng ngày</option>
                            <option value="academic" {{ $topic == 'academic' ? 'selected' : '' }}>Trường học / Học thuật</option>
                            <option value="workplace" {{ $topic == 'workplace' ? 'selected' : '' }}>Công việc / Văn phòng</option>
                            <option value="travel" {{ $topic == 'travel' ? 'selected' : '' }}>Du lịch</option>
                            <option value="mixed" {{ $topic == 'mixed' ? 'selected' : '' }}>Không giới hạn (Tổng hợp)</option>
                            <option value="custom" {{ $isCustom ? 'selected' : '' }}>Tự chọn chủ đề</option>
                        </select>

                        <div class="mt-2">
                            <label for="custom_topic_text" class="form-label">Chủ đề cụ thể (nếu có):</label>
                            <input type="text" id="custom_topic_text" name="custom_topic_text" class="form-control"
                                placeholder="Nhập chủ đề mong muốn (ví dụ: Môi trường, Công nghệ)"
                                value="{{ $isCustom ? $topic : '' }}">
                        </div>
                    </div>

                    <!-- Giọng đọc -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-volume-up"></i> Giọng đọc (Accent)
                        </label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="accent_british" name="accent" value="british">
                                <label for="accent_british">British English</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="accent_american" name="accent" value="american">
                                <label for="accent_american">American English</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="accent_mixed" name="accent" value="mixed" checked>
                                <label for="accent_mixed">Không phân biệt</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loại đề (Tùy chọn nâng cao) -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tasks"></i> Loại đề (Tùy chọn nâng cao)
                    </label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="part1" name="test_parts[]" value="part1" checked>
                            <label for="part1">Part 1: Đoạn ngắn hội thoại</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="part2" name="test_parts[]" value="part2" checked>
                            <label for="part2">Part 2: Đoạn dài độc thoại</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="part3" name="test_parts[]" value="part3" checked>
                            <label for="part3">Part 3: Bài giảng học thuật</label>
                        </div>
                    </div>
                </div>

                <!-- Định dạng xuất ra -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-download"></i> Định dạng xuất ra
                    </label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="format_web" name="output_formats[]" value="web" checked>
                            <label for="format_web">Làm bài trực tiếp trên web</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="format_pdf" name="output_formats[]" value="pdf">
                            <label for="format_pdf">PDF có audio link</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="format_word" name="output_formats[]" value="word">
                            <label for="format_word">File Word để in</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="format_audio" name="output_formats[]" value="audio">
                            <label for="format_audio">Tải xuống audio + câu hỏi</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-magic"></i>
                    <span class="btn-text">Tạo đề luyện tập</span>
                </button>
            </form>
        </div>

        <div id="generatedTest" class="card hidden">
            <div class="card-title">
                <i class="fas fa-file-alt"></i>
                Đề luyện tập của bạn
            </div>
            
            <div class="test-info" id="testInfo">
                <!-- Test information will be displayed here -->
            </div>
            
            <div class="generated-content">
                <div id="testContent">
                    <!-- Generated test content will be displayed here -->
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <button id="startTest" class="btn btn-success">
                    <i class="fas fa-play"></i>
                    Bắt đầu làm bài
                </button>
            </div>
        </div>
    </div>

    <script>
        // Setup CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Handle custom question count
        document.getElementById('question_count').addEventListener('change', function() {
            const customCount = document.getElementById('custom_count');
            if (this.value === 'custom') {
                customCount.classList.add('show');
            } else {
                customCount.classList.remove('show');
            }
        });

        // Handle custom topic
        document.getElementById('topic').addEventListener('change', function() {
            const customTopic = document.getElementById('custom_topic');
            if (this.value === 'custom') {
                customTopic.classList.add('show');
            } else {
                customTopic.classList.remove('show');
            }
        });

        // Handle form submission
        document.getElementById('listeningForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const btnText = submitBtn.querySelector('.btn-text');
            const originalText = btnText.textContent;
            
            // Validate at least one part is selected
            const selectedParts = document.querySelectorAll('input[name="test_parts[]"]:checked');
            if (selectedParts.length === 0) {
                showAlert('Vui lòng chọn ít nhất một loại đề để luyện tập!', 'error');
                return;
            }

            // Validate at least one output format is selected
            const selectedFormats = document.querySelectorAll('input[name="output_formats[]"]:checked');
            if (selectedFormats.length === 0) {
                showAlert('Vui lòng chọn ít nhất một định dạng xuất ra!', 'error');
                return;
            }
            
            // Show loading state
            btnText.innerHTML = '<span class="loading"></span> Đang tạo đề...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(this);
                
                // Convert checkbox arrays to proper format
                const testParts = Array.from(selectedParts).map(cb => cb.value);
                const outputFormats = Array.from(selectedFormats).map(cb => cb.value);
                
                formData.delete('test_parts[]');
                formData.delete('output_formats[]');
                
                testParts.forEach(part => formData.append('test_parts[]', part));
                outputFormats.forEach(format => formData.append('output_formats[]', format));

                const response = await fetch('/listening/generate-test', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Có lỗi xảy ra khi tạo đề');
                }

                displayGeneratedTest(data);
                showAlert('Đề luyện tập đã được tạo thành công!', 'success');

            } catch (error) {
                showAlert('Có lỗi xảy ra: ' + error.message, 'error');
            } finally {
                // Reset button
                btnText.textContent = originalText;
                submitBtn.disabled = false;
            }
        });

        function displayGeneratedTest(data) {
            // Display test information
            document.getElementById('testInfo').innerHTML = `
                <div class="info-item">
                    <div class="info-value">${data.level}</div>
                    <div class="info-label">Trình độ</div>
                </div>
                <div class="info-item">
                    <div class="info-value">${data.question_count}</div>
                    <div class="info-label">Số câu hỏi</div>
                </div>
                <div class="info-item">
                    <div class="info-value">${data.topic}</div>
                    <div class="info-label">Chủ đề</div>
                </div>
                <div class="info-item">
                    <div class="info-value">${data.accent}</div>
                    <div class="info-label">Giọng đọc</div>
                </div>
                <div class="info-item">
                    <div class="info-value">${data.parts.join(', ')}</div>
                    <div class="info-label">Phần thi</div>
                </div>
                <div class="info-item">
                    <div class="info-value">${data.duration} phút</div>
                    <div class="info-label">Thời gian</div>
                </div>
            `;

            // Display test content
            document.getElementById('testContent').innerHTML = data.content;

            const generatedTest = document.getElementById('generatedTest');
            generatedTest.classList.remove('hidden');
            generatedTest.classList.add('fade-in');
            generatedTest.scrollIntoView({ behavior: 'smooth' });
        }

        function showAlert(message, type) {
            removeAlerts();
            
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.innerHTML = `<i class="fas fa-${getAlertIcon(type)}"></i> ${message}`;
            
            document.querySelector('.container').insertBefore(alert, document.querySelector('.card'));
            
            // Auto remove success alerts after 5 seconds
            if (type === 'success') {
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            }
        }

        function getAlertIcon(type) {
            switch(type) {
                case 'error': return 'exclamation-circle';
                case 'success': return 'check-circle';
                case 'info': return 'info-circle';
                default: return 'info-circle';
            }
        }

        function removeAlerts() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => alert.remove());
        }

        // Handle start test button
        document.getElementById('startTest').addEventListener('click', function() {
            showAlert('Chức năng làm bài sẽ được triển khai trong phiên bản tiếp theo!', 'info');
        });
    </script>
</body>
</html>