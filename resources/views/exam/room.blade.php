@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow m-3">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0">Vui lòng cấp quyền sử dụng micro cho trình duyệt trước khi thi.</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2 text-center mb-4">
                            <div class="user-info-container p-3 border rounded bg-light">
                                <div class="user-info mt-2">
                                    <p class="mb-1"><strong>Họ tên:</strong> <span id="user-fullname">{{ $user->name}}</span></p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $user->email}}</p>
                                    <p class="mb-1"><strong>Loại tài khoản:</strong> Miễn phí</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="step-container">
                                <div class="step-content">
                                    <h5 class="text-primary">CẤU TRÚC BÀI THI</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-headphones me-2 text-secondary"></i>Kỹ năng số 1: <strong>NGHE</strong> - 3 phần (47 phút)</li>
                                        <li class="mb-2"><i class="fas fa-book-open me-2 text-secondary"></i>Kỹ năng số 2: <strong>ĐỌC</strong> - 4 phần (60 phút)</li>
                                        <li class="mb-2"><i class="fas fa-pen me-2 text-secondary"></i>Kỹ năng số 3: <strong>VIẾT</strong> - 2 phần (60 phút)</li>
                                        <li class="mb-2"><i class="fas fa-microphone me-2 text-secondary"></i>Kỹ năng số 4: <strong>NÓI</strong> - 3 phần (12 phút)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="step-container">
                                <div class="step-content">
                                    <h5 class="text-primary">KIỂM TRA ÂM THANH</h5>
                                    <p><i class="fas fa-volume-up me-2 text-secondary"></i>Bước 1: Mở loa hoặc đeo tai nghe để nghe một đoạn audio bên dưới.</p>
                                    
                                    <div class="audio-player mb-3 mt-3">
                                        <audio id="test-audio" controls class="w-100 rounded" onerror="handleAudioError()">
                                            <source src="{{ asset('storage/audio/audioTest.mp3') }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                    
                                    <p><i class="fas fa-microphone-alt me-2 text-secondary"></i>Bước 2: Để mic thu âm sát miệng.</p>
                                    <p><i class="fas fa-play-circle me-2 text-secondary"></i>Bước 3: Nhấp vào nút "Thu âm" để bắt đầu thu âm. Sau đó, nhấp vào nút "Nghe lại".</p>
                                    
                                    <div class="audio-recorder mt-3 mb-3">
                                        <div id="audio-visualizer" class="bg-light rounded mb-2 border" style="height: 60px; width: 100%;"></div>
                                        <div class="mic-status text-center mb-2" id="mic-status" role="status">
                                            <span class="badge bg-secondary">Chưa kết nối microphone</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button id="record-btn" class="btn btn-danger mx-1" aria-label="Bắt đầu hoặc dừng thu âm">
                                                <i class="fas fa-microphone me-1"></i> Thu âm
                                            </button>
                                            <button id="play-recorded-btn" class="btn btn-info mx-1" disabled aria-label="Nghe lại bản thu âm">
                                                <i class="fas fa-play me-1"></i> Nghe lại
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="step-container">
                                <div class="step-content">
                                    <h5 class="text-primary">LƯU Ý</h5>
                                    <div class="alert alert-warning">
                                        <p><i class="fas fa-exclamation-triangle me-2"></i>Khi hết thời gian của từng kỹ năng, hệ thống sẽ tự động chuyển sang kỹ năng tiếp theo. Thí sinh không thể thao tác được với kỹ năng đã làm trước đó.</p>
                                    </div>
                                    <div class="alert alert-info">
                                        <p><i class="fas fa-info-circle me-2"></i>Để chuyển part hay kỹ năng, thí sinh click vào nút "TIẾP TỤC".</p>
                                    </div>
                                    
                                    <div class="d-grid gap-2 mt-4">
                                        <a href="{{ isset($exam_id) ? route('exam.detail', $exam_id) : '#' }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-file-alt me-2"></i>NHẬN ĐỀ
                                        </a>
                                    </div>
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
    .step-container {
        position: relative;
        margin-bottom: 20px;
        height: 100%;
    }
    
    .step-number {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .step-content {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        height: calc(100% - 20px);
        overflow-y: auto;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        background-color: #fff;
    }
    
    .step-content h5 {
        margin-bottom: 15px;
        font-weight: bold;
        border-bottom: 2px solid #f8f9fa;
        padding-bottom: 8px;
    }
    
    .audio-player audio:focus {
        outline: none;
    }
    
    .recording {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        #print-section, #print-section * {
            visibility: visible;
        }
        #print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            page-break-inside: avoid;
        }
    }
</style>

<!-- Print Section (Hidden) -->
<div id="print-section" style="display: none;">
    <div style="padding: 20px; border: 1px solid #ddd; text-align: center;">
        <h3>Thông tin thí sinh</h3>
        <p><strong>Họ tên:</strong> <span id="print-fullname">Nguyễn Đức Thắng</span></p>
        <p><strong>Mã lượt thi:</strong> 329048</p>
        <p><strong>Ngày thi:</strong> <span id="print-date"></span></p>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let stream = null;
        let mediaRecorder = null;
        let audioChunks = [];
        let recordedAudio = null;
        let audioContext = null;
        let cleanupVisualizer = null;
        const micStatus = document.getElementById('mic-status');
        const recordBtn = document.getElementById('record-btn');
        const playRecordedBtn = document.getElementById('play-recorded-btn');
        const visualizer = document.getElementById('audio-visualizer');

        // Update date for print function
        const today = new Date();
        document.getElementById('print-date').textContent = today.toLocaleDateString('vi-VN');

       –

        // Print user name function
        window.printUserName = function() {
            const username = document.getElementById('user-fullname').textContent;
            document.getElementById('print-fullname').textContent = username;
            window.print();
        };

        // Audio context management
        function getAudioContext() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            return audioContext;
        }

        // Stream cleanup
        function cleanupStream() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            if (audioContext) {
                audioContext.close();
                audioContext = null;
            }
            if (cleanupVisualizer) {
                cleanupVisualizer();
            }
        }

        // Debounce utility
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Test microphone access
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function(audioStream) {
                micStatus.innerHTML = '<span class="badge bg-success">Microphone đã kết nối</span>';
                stream = audioStream;

                const analyser = getAudioContext().createAnalyser();
                const source = getAudioContext().createMediaStreamSource(stream);
                source.connect(analyser);

                analyser.fftSize = 256;
                const bufferLength = analyser.frequencyBinCount;
                const dataArray = new Uint8Array(bufferLength);

                const ctx = document.createElement('canvas').getContext('2d');
                visualizer.innerHTML = '';
                visualizer.appendChild(ctx.canvas);
                ctx.canvas.width = visualizer.clientWidth;
                ctx.canvas.height = visualizer.clientHeight;

                ctx.fillStyle = '#f8f9fa';
                ctx.fillRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.fillStyle = '#6c757d';
                ctx.font = '14px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('Sẵn sàng thu âm', ctx.canvas.width / 2, ctx.canvas.height / 2);
            })
            .catch(function(err) {
                console.error('Error accessing microphone:', err);
                micStatus.innerHTML = '<span class="badge bg-danger">Không thể kết nối microphone</span>';
                visualizer.innerHTML = '<div class="alert alert-danger py-2 text-center">Vui lòng cấp quyền truy cập microphone và tải lại trang</div>';
                recordBtn.disabled = true;
                recordBtn.innerHTML = '<i class="fas fa-microphone-slash me-1"></i> Micro không khả dụng';
            });

        // Audio recording functionality
        recordBtn.addEventListener('click', function() {
            if (recordBtn.disabled) return;

            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
                cleanupStream();
                recordBtn.innerHTML = '<i class="fas fa-microphone me-1"></i> Thu âm';
                recordBtn.classList.remove('btn-secondary', 'recording');
                recordBtn.classList.add('btn-danger');
                micStatus.innerHTML = '<span class="badge bg-success">Đã thu xong</span>';
                return;
            }

            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(function(audioStream) {
                    stream = audioStream;

                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];

                    mediaRecorder.addEventListener('dataavailable', function(e) {
                        audioChunks.push(e.data);
                    });

                    mediaRecorder.addEventListener('stop', function() {
                        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                        recordedAudio = new Audio(URL.createObjectURL(audioBlob));
                        playRecordedBtn.disabled = false;
                    });

                    mediaRecorder.start();
                    recordBtn.innerHTML = '<i class="fas fa-stop-circle me-1"></i> Dừng thu âm';
                    recordBtn.classList.remove('btn-danger');
                    recordBtn.classList.add('btn-secondary', 'recording');
                    micStatus.innerHTML = '<span class="badge bg-warning text-dark">Đang thu âm...</span>';

                    cleanupVisualizer = visualizeAudio(audioStream);
                })
                .catch(function(err) {
                    console.error('Error accessing microphone:', err);
                    micStatus.innerHTML = '<span class="badge bg-danger">Không thể kết nối microphone</span>';
                });
        });

        playRecordedBtn.addEventListener('click', function() {
            if (recordedAudio) {
                recordedAudio.play();
                micStatus.innerHTML = '<span class="badge bg-info">Đang phát lại...</span>';

                recordedAudio.onended = function() {
                    micStatus.innerHTML = '<span class="badge bg-success">Sẵn sàng</span>';
                };

                recordedAudio.onpause = function() {
                    micStatus.innerHTML = '<span class="badge bg-success">Sẵn sàng</span>';
                };
            }
        });

        // Audio visualization
        function visualizeAudio(stream) {
            const analyser = getAudioContext().createAnalyser();
            const source = getAudioContext().createMediaStreamSource(stream);
            source.connect(analyser);

            analyser.fftSize = 256;
            const bufferLength = analyser.frequencyBinCount;
            const dataArray = new Uint8Array(bufferLength);

            const ctx = document.createElement('canvas').getContext('2d');
            visualizer.innerHTML = '';
            visualizer.appendChild(ctx.canvas);

            function resizeCanvas() {
                ctx.canvas.width = visualizer.clientWidth;
                ctx.canvas.height = visualizer.clientHeight;
            }

            resizeCanvas();
            const debouncedResize = debounce(resizeCanvas, 100);
            window.addEventListener('resize', debouncedResize);

            function draw() {
                if (mediaRecorder && mediaRecorder.state === 'recording') {
                    requestAnimationFrame(draw);

                    analyser.getByteFrequencyData(dataArray);

                    ctx.fillStyle = '#f8f9fa';
                    ctx.fillRect(0, 0, ctx.canvas.width, ctx.canvas.height);

                    const barWidth = (ctx.canvas.width / bufferLength) * 2.5;
                    let x = 0;

                    for (let i = 0; i < bufferLength; i++) {
                        const barHeight = dataArray[i] / 2;
                        const intensity = dataArray[i] / 256;
                        const r = Math.floor(220 * intensity);
                        const g = Math.floor(53 * intensity);
                        const b = Math.floor(69 * intensity);

                        ctx.fillStyle = `rgb(${r}, ${g}, ${b})`;
                        ctx.fillRect(x, ctx.canvas.height - barHeight, barWidth, barHeight);

                        x += barWidth + 1;
                    }
                } else {
                    ctx.fillStyle = '#f8f9fa';
                    ctx.fillRect(0, buck ctx.canvas.width, ctx.canvas.height);
                    ctx.fillStyle = '#6c757d';
                    ctx.font = '14px Arial';
                    ctx.textAlign = 'center';

                    if (recordedAudio) {
                        ctx.fillText('Sẵn sàng phát lại', ctx.canvas.width / 2, ctx.canvas.height / 2);
                    } else {
                        ctx.fillText('Sẵn sàng thu âm', ctx.canvas.width / 2, ctx.canvas.height / 2);
                    }
                }
            }

            draw();

            return () => window.removeEventListener('resize', debouncedResize);
        }

        // Handle audio file error
        window.handleAudioError = function() {
            const audioPlayer = document.querySelector('.audio-player');
            audioPlayer.innerHTML = '<div class="alert alert-danger py-2 text-center">Không thể tải tệp âm thanh. Vui lòng kiểm tra kết nối hoặc liên hệ hỗ trợ.</div>';
        };

        // Cleanup on page unload
        window.addEventListener('beforeunload', cleanupStream);
    });
</script>
@endsection