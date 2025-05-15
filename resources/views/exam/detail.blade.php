@extends('layouts.app')

@section('content')
<div style="background-color: #102342;">
    <div class="container py-4" style="color: white; min-height: 100vh; position: relative;">
        <form id="examForm" action="{{ route('exam.submit', $exam->id) }}" method="POST">
            @csrf
            <!-- Thanh top: Thời gian + Lưu bài + Nộp bài + Số câu -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <div>
                    <span id="questionProgress" class="badge bg-info text-dark fs-6">0/{{ $exam->question_count ?? 0 }} câu đã trả lời</span>
                </div>

                <div class="text-center flex-grow-1">
                    <div class="bg-primary px-3 py-1 rounded-pill shadow-sm" style="display: inline-block; min-width: 120px;">
                        <span class="text-white fw-bold fs-5" id="timer">47:00</span>
                    </div>
                </div>

                <div>
                    <button type="button" class="btn btn-success btn-md me-2" id="btnSave">Lưu bài</button>
                    <button type="submit" class="btn btn-primary btn-md" id="btnSubmit">Nộp bài</button>
                </div>
            </div>

            <!-- Nội dung kỹ năng và part -->
            <div id="skillContent">
                <!-- LISTENING -->
                @if(isset($listening))
                <div id="listeningContent">
                    <ul class="nav nav-tabs mb-3" id="listeningTabs">
                        @foreach($listening as $sectionId => $listeningData)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                        onclick="switchPart('listeningPart{{ $loop->iteration }}', event)"
                                        id="listeningPartBtn{{ $loop->iteration }}">
                                    Part {{ $loop->iteration }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($listening as $sectionId => $listeningData)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="listeningPart{{ $loop->iteration }}">
                                <h5 class="text-warning">Listening - Part {{ $loop->iteration }}</h5>
                                
                                @if(count($listeningData['audios']) > 0)
                                <div class="mb-3">
                                    <audio controls class="w-100 mb-3">
                                        <source src="{{ asset('storage/audio/' . $listeningData['audios'][0]->audio_url) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                                @endif
                                
                                @foreach($listeningData['questions'] as $index => $question)
                                <div class="mb-4">
                                    <p><strong>Question {{ $index + 1 }}:</strong> {{ $question->question_text }}</p>
                                    @foreach($question->choices as $choice)
                                    <div class="form-check">
                                        <input type="radio" 
                                               id="q{{ $question->id }}_{{ $choice->label }}" 
                                               name="answers[{{ $question->id }}]" 
                                               value="{{ $choice->label }}" 
                                               class="form-check-input answer-input">
                                        <label for="q{{ $question->id }}_{{ $choice->label }}" class="form-check-label">
                                            {{ $choice->label }}. {{ $choice->content }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- READING -->
                @if(isset($reading))
                <div id="readingContent" class="d-none">
                    <ul class="nav nav-tabs mb-3" id="readingTabs">
                        @foreach($reading as $sectionId => $readingPassages)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                        onclick="switchPart('readingPart{{ $loop->iteration }}', event)"
                                        id="readingPartBtn{{ $loop->iteration }}">
                                    Part {{ $loop->iteration }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($reading as $sectionId => $readingPassages)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="readingPart{{ $loop->iteration }}">
                                <div class="row">
                                    <!-- Chỉ hiển thị bài đọc và câu hỏi cho passage đầu tiên trong part -->
                                    @php
                                        $passageData = $readingPassages[0]; // Lấy passage đầu tiên
                                    @endphp
                                    <!-- Bài đọc bên trái -->
                                    <div class="col-md-6 border-end pe-4" style="max-height: 80vh; overflow-y: auto;">
                                        <h5 class="text-warning">Reading - Part {{ $loop->iteration }}</h5>
                                        <div class="mb-3">
                                            <h6>{{ $passageData['passage']->title }}</h6>
                                            <div>{!! $passageData['passage']->content !!}</div>
                                        </div>
                                    </div>

                                    <!-- Câu hỏi bên phải -->
                                    <div class="col-md-6 ps-4" style="max-height: 80vh; overflow-y: auto;">
                                        <h5 class="text-warning">Questions</h5>
                                        @foreach($passageData['questions'] as $index => $question)
                                            <div class="mb-4">
                                                <p><strong>Question {{ $index + 1 }}:</strong> {{ $question->question_text }}</p>
                                                @foreach($question->choices as $choice)
                                                <div class="form-check">
                                                    <input type="radio" 
                                                           id="q{{ $question->id }}_{{ $choice->label }}" 
                                                           name="answers[{{ $question->id }}]" 
                                                           value="{{ $choice->label }}" 
                                                           class="form-check-input answer-input">
                                                    <label for="q{{ $question->id }}_{{ $choice->label }}" class="form-check-label">
                                                        {{ $choice->label }}. {{ $choice->content }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- WRITING -->
                @if(isset($writing))
                <div id="writingContent" class="d-none">
                    <ul class="nav nav-tabs mb-3" id="writingTabs">
                        @foreach($writing as $sectionId => $writingData)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                        onclick="switchPart('writingPart{{ $loop->iteration }}', event)"
                                        id="writingPartBtn{{ $loop->iteration }}">
                                    Part {{ $loop->iteration }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($writing as $sectionId => $writingData)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="writingPart{{ $loop->iteration }}">
                                <h5 class="text-warning">Writing - Part {{ $loop->iteration }}</h5>
                                
                                @foreach($writingData['prompts'] as $prompt)
                                <div class="mb-4">
                                    <p>{!! $prompt->prompt_text !!}</p>
                                    <textarea class="form-control answer-input writing-textarea" 
                                              rows="8" 
                                              name="answers[writing_{{ $prompt->id }}]" 
                                              id="writingTextarea{{ $prompt->id }}"></textarea>
                                    <div class="text-end mt-2 text-light">
                                        <small>Words: <span id="wordCount{{ $prompt->id }}">0</span></small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- SPEAKING -->
                @if(isset($speaking))
                <div id="speakingContent" class="d-none">
                    <ul class="nav nav-tabs mb-3" id="speakingTabs">
                        @foreach($speaking as $sectionId => $speakingData)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                        onclick="switchPart('speakingPart{{ $loop->iteration }}', event)"
                                        id="speakingPartBtn{{ $loop->iteration }}">
                                    Part {{ $loop->iteration }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($speaking as $sectionId => $speakingData)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="speakingPart{{ $loop->iteration }}">
                                <h5 class="text-warning">Speaking - Part {{ $loop->iteration }}</h5>
                                
                                @foreach($speakingData['prompts'] as $prompt)
                                <div class="mb-4">
                                    <p>{!! $prompt->prompt_text !!}</p>
                                    <div class="mb-3">
                                        <canvas id="audioVisualizer{{ $prompt->id }}" class="bg-light rounded border" style="height: 60px; width: 100%;"></canvas>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="button" class="btn btn-danger record-btn" 
                                                data-prompt-id="{{ $prompt->id }}">
                                            🎤 Bắt đầu ghi âm
                                        </button>
                                        <span class="text-light recording-status" id="recordingStatus{{ $prompt->id }}">
                                            Chưa ghi âm
                                        </span>
                                        <audio id="audioPreview{{ $prompt->id }}" controls class="d-none"></audio>
                                        <input type="hidden" name="answers[speaking_{{ $prompt->id }}]" 
                                               id="speakingAnswer{{ $prompt->id }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Tabs kỹ năng ở giữa dưới -->
            <div class="position-fixed bottom-0 start-50 translate-middle-x mb-3">
                <ul class="nav nav-pills">
                    @if(isset($listening))
                    <li class="nav-item"><button type="button" class="nav-link" id="btnListening">Listening</button></li>
                    @endif
                    
                    @if(isset($reading))
                    <li class="nav-item"><button type="button" class="nav-link" id="btnReading">Reading</button></li>
                    @endif
                    
                    @if(isset($writing))
                    <li class="nav-item"><button type="button" class="nav-link" id="btnWriting">Writing</button></li>
                    @endif
                    
                    @if(isset($speaking))
                    <li class="nav-item"><button type="button" class="nav-link" id="btnSpeaking">Speaking</button></li>
                    @endif
                </ul>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT -->
<script>
    function switchPart(partId, event) {
        event.preventDefault();
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        const selectedPane = document.getElementById(partId);
        if (selectedPane) {
            selectedPane.classList.add('show', 'active');
        }
        document.querySelectorAll('.nav-link').forEach(btn => {
            btn.classList.remove('active');
        });
        const activeButton = document.querySelector(`[onclick="switchPart('${partId}', event)"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }
        // Update the answer count when switching tabs
        updateAnswerCount();
    }

    function countWords(text) {
        return text.trim().split(/\s+/).filter(word => word.length > 0).length;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Skill navigation and timer configuration
        const skillConfig = {
            btnListening: {
                content: 'listeningContent',
                minutes: 47,
                firstPart: 'listeningPart1'
            },
            btnReading: {
                content: 'readingContent',
                minutes: 60,
                firstPart: 'readingPart1'
            },
            btnWriting: {
                content: 'writingContent',
                minutes: 60,
                firstPart: 'writingPart1'
            },
            btnSpeaking: {
                content: 'speakingContent',
                minutes: 12,
                firstPart: 'speakingPart1'
            }
        };

        const allContents = Object.values(skillConfig)
            .map(config => document.getElementById(config.content))
            .filter(el => el !== null);
        const allBtns = Object.keys(skillConfig)
            .map(id => document.getElementById(id))
            .filter(el => el !== null);
        const questionProgress = document.getElementById('questionProgress');
        const timerEl = document.getElementById('timer');
        const submitBtn = document.getElementById('btnSubmit');

        let currentSkill = 'btnListening';
        let totalSeconds = skillConfig[currentSkill].minutes * 60;
        let interval;
        let completedSkills = new Set();
        let audioContext = null;
        let mediaRecorder = null;
        let audioChunks = [];
        let cleanupVisualizer = null;

        // Timer function
        function startTimer(minutes) {
            clearInterval(interval);
            totalSeconds = minutes * 60;
            interval = setInterval(() => {
                const minutes = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
                const seconds = String(totalSeconds % 60).padStart(2, '0');
                if (timerEl) {
                    timerEl.textContent = `${minutes}:${seconds}`;
                }
                if (totalSeconds > 0) {
                    totalSeconds--;
                } else {
                    clearInterval(interval);
                    alert("Hết giờ! Bài làm của bạn sẽ được nộp.");
                    if (submitBtn) {
                        submitBtn.click();
                    }
                }
            }, 1000);
        }

       // Update answer count based on the currently active part
        function updateAnswerCount() {
            const questionProgress = document.getElementById('questionProgress');
            // Find the currently active part
            const activePart = document.querySelector('.tab-pane.show.active');
            if (!activePart) return;

            // Count the total number of questions in the active part
            const questions = activePart.querySelectorAll('p > strong');
            let total = questions.length;

            // Count the number of answered questions
            let count = 0;
            const answerInputs = activePart.querySelectorAll('.answer-input');
            answerInputs.forEach(el => {
                const parentQuestion = el.closest('.mb-4'); // Each question is wrapped in a div with class mb-4
                if (parentQuestion) {
                    if ((el.type === 'radio' && el.checked) || 
                        (el.tagName === 'TEXTAREA' && el.value.trim() !== '') ||
                        (el.type === 'hidden' && el.value.trim() !== '')) {
                        count++;
                    }
                }
            });

            // Update the progress text
            questionProgress.textContent = `${count}/${total} câu đã trả lời`;
        }

        // Audio context management
        function getAudioContext() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            return audioContext;
        }

        // Stream cleanup
        function cleanupStream() {
            if (mediaRecorder && mediaRecorder.stream) {
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
            if (audioContext) {
                audioContext.close();
                audioContext = null;
            }
            if (cleanupVisualizer) {
                cleanupVisualizer();
                cleanupVisualizer = null;
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

        // Audio visualization
        function visualizeAudio(stream, canvasId) {
            console.log('Visualizing audio for canvas:', canvasId);
            const analyser = getAudioContext().createAnalyser();
            const source = getAudioContext().createMediaStreamSource(stream);
            source.connect(analyser);

            analyser.fftSize = 256;
            const bufferLength = analyser.frequencyBinCount;
            const dataArray = new Uint8Array(bufferLength);

            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');

            function resizeCanvas() {
                canvas.width = canvas.parentElement.clientWidth;
                canvas.height = canvas.parentElement.clientHeight;
            }

            resizeCanvas();
            const debouncedResize = debounce(resizeCanvas, 100);
            window.addEventListener('resize', debouncedResize);

            function draw() {
                if (mediaRecorder && mediaRecorder.state === 'recording') {
                    requestAnimationFrame(draw);

                    analyser.getByteFrequencyData(dataArray);

                    ctx.fillStyle = '#f8f9fa';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    const barWidth = (canvas.width / bufferLength) * 2.5;
                    let x = 0;

                    for (let i = 0; i < bufferLength; i++) {
                        const barHeight = dataArray[i] / 2;
                        const intensity = dataArray[i] / 256;
                        const r = Math.floor(220 * intensity);
                        const g = Math.floor(53 * intensity);
                        const b = Math.floor(69 * intensity);

                        ctx.fillStyle = `rgb(${r}, ${g}, ${b})`;
                        ctx.fillRect(x, canvas.height - barHeight, barWidth, barHeight);

                        x += barWidth + 1;
                    }
                } else {
                    ctx.fillStyle = '#f8f9fa';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.fillStyle = '#6c757d';
                    ctx.font = '14px Arial';
                    ctx.textAlign = 'center';

                    const statusElement = document.getElementById(`recordingStatus${canvasId.replace('audioVisualizer', '')}`);
                    if (statusElement && statusElement.textContent.includes('Đã ghi âm')) {
                        ctx.fillText('Sẵn sàng phát lại', canvas.width / 2, canvas.height / 2);
                    } else {
                        ctx.fillText('Sẵn sàng ghi âm', canvas.width / 2, canvas.height / 2);
                    }
                }
            }

            draw();

            return () => window.removeEventListener('resize', debouncedResize);
        }

        // Skill tab switching
        allBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', () => {
                    if (completedSkills.has(btn.id) || btn.id === currentSkill) {
                        return; // Prevent switching to completed skills or same skill
                    }

                    // Mark current skill as completed
                    completedSkills.add(currentSkill);

                    // Update UI
                    allContents.forEach(el => {
                        if (el) el.classList.add('d-none');
                    });
                    allBtns.forEach(b => {
                        if (b) b.classList.remove('active');
                    });

                    const config = skillConfig[btn.id];
                    const targetEl = document.getElementById(config.content);
                    if (targetEl) {
                        targetEl.classList.remove('d-none');
                        btn.classList.add('active');
                        currentSkill = btn.id;

                        // Activate first part of new skill
                        switchPart(config.firstPart, { preventDefault: () => {} });

                        // Start new timer
                        startTimer(config.minutes);
                    }
                });
            }
        });

        // Listen for answer changes
        document.querySelectorAll('.answer-input').forEach(el => {
        el.addEventListener('input', updateAnswerCount);
        el.addEventListener('change', updateAnswerCount);
    });

        // Word counting for writing
        document.querySelectorAll('.writing-textarea').forEach(textarea => {
            const id = textarea.id.replace('writingTextarea', '');
            const countElement = document.getElementById('wordCount' + id);
            textarea.addEventListener('input', () => {
                if (countElement) {
                    countElement.textContent = countWords(textarea.value);
                }
            });
        });

        // Speaking recording with visualizer
        document.querySelectorAll('.record-btn').forEach(btn => {
            const promptId = btn.getAttribute('data-prompt-id');
            const statusElement = document.getElementById('recordingStatus' + promptId);
            const audioPreview = document.getElementById('audioPreview' + promptId);
            const answerInput = document.getElementById('speakingAnswer' + promptId);
            const visualizerCanvas = document.getElementById('audioVisualizer' + promptId);

            btn.addEventListener('click', async function() {
                if (btn.textContent.includes('Bắt đầu') || btn.textContent.includes('Ghi âm lại')) {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        statusElement.textContent = 'Đang ghi âm...';
                        btn.textContent = '⏹️ Dừng ghi âm';
                        btn.classList.remove('btn-danger', 'btn-success');
                        btn.classList.add('btn-warning');

                        audioChunks = [];
                        mediaRecorder = new MediaRecorder(stream);

                        mediaRecorder.ondataavailable = (e) => {
                            audioChunks.push(e.data);
                        };

                        mediaRecorder.onstop = () => {
                            const audioBlob = new Blob(audioChunks, { type: 'audio/mp3' });
                            const audioUrl = URL.createObjectURL(audioBlob);
                            audioPreview.src = audioUrl;
                            audioPreview.classList.remove('d-none');

                            // Convert to base64 for form submission
                            const reader = new FileReader();
                            reader.readAsDataURL(audioBlob);
                            reader.onloadend = () => {
                                const base64data = reader.result;
                                answerInput.value = base64data;
                                updateAnswerCount();
                            };

                            cleanupStream();
                        };

                        mediaRecorder.start();
                        cleanupVisualizer = visualizeAudio(stream, 'audioVisualizer' + promptId);
                    } catch (error) {
                        console.error("Error accessing microphone:", error);
                        let errorMessage = 'Không thể truy cập microphone';
                        if (error.name === 'NotAllowedError') {
                            errorMessage = 'Vui lòng cấp quyền microphone trong cài đặt trình duyệt';
                        } else if (error.name === 'NotFoundError') {
                            errorMessage = 'Không tìm thấy thiết bị microphone';
                        } else if (error.name === 'NotReadableError') {
                            errorMessage = 'Microphone đang được sử dụng bởi ứng dụng khác';
                        }
                        alert(`${errorMessage}. Vui lòng kiểm tra và thử lại.`);
                        statusElement.textContent = 'Lỗi ghi âm';
                    }
                } else {
                    mediaRecorder.stop();
                    statusElement.textContent = 'Đã ghi âm xong';
                    btn.textContent = '🎤 Ghi âm lại';
                    btn.classList.remove('btn-warning');
                    btn.classList.add('btn-success');
                }
            });
        });

        // Auto-save
        const examForm = document.getElementById('examForm');
        const saveBtn = document.getElementById('btnSave');
        if (saveBtn) {
            saveBtn.addEventListener('click', function() {
                localStorage.setItem('examAnswers', JSON.stringify(new FormData(examForm)));
                alert("Đã lưu bài làm của bạn.");
            });
        }

        // Load saved answers
        const savedAnswers = localStorage.getItem('examAnswers');
        if (savedAnswers) {
            // Implement loading saved answers
        }

        // Initial setup: Ensure correct skill tab is active
        function initializeSkillTab() {
            allContents.forEach(el => {
                if (el) el.classList.add('d-none');
            });
            allBtns.forEach(b => {
                if (b) b.classList.remove('active');
            });

            const config = skillConfig[currentSkill];
            const targetEl = document.getElementById(config.content);
            if (targetEl) {
                targetEl.classList.remove('d-none');
                document.getElementById(currentSkill).classList.add('active');
                switchPart(config.firstPart, { preventDefault: () => {} });
            }
            // Update answer count after initializing the tab
            updateAnswerCount();
        }

        // Initial setup
        updateAnswerCount();
        startTimer(skillConfig[currentSkill].minutes);
        initializeSkillTab();
    });
</script>
@endsection