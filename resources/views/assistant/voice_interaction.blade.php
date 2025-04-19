@extends('layouts.app')

@section('content')
<div class="container px-5 my-5" style="min-height: 80vh;">
    <div class="row mb-4">
        <div class="col-lg-11 mx-auto">
            <h1 class="fw-bold text-primary mb-2">Trợ lý học tiếng Anh bằng giọng nói</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">DTU English Hub</a></li>
                    <li class="breadcrumb-item active">Trợ lý AI giọng nói</li>   
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="chat-container">
                <div class="chat-header">
                    <div class="d-flex align-items-center">
                        <div class="avatar-container me-2">
                            <div class="avatar">
                                <i class="fas fa-robot"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-0">Trợ lý học tiếng Anh</h5>
                            <div class="status"><span class="status-indicator"></span> Trực tuyến</div>
                        </div>
                    </div>
                </div>
                
                <div class="chat-messages" id="chat-messages">
                    <div class="message system">
                        <div class="message-content">
                            <p>Xin chào! Tôi là trợ lý học tiếng Anh của bạn. Bạn có thể hỏi tôi về từ vựng, ngữ pháp, cách phát âm hoặc bất kỳ điều gì liên quan đến tiếng Anh.</p>
                        </div>
                    </div>
                    <!-- Messages will be added here dynamically -->
                </div>

                <div class="chat-input-area">
                    <div class="input-wrapper">
                        <textarea id="voice-transcript" class="chat-input" placeholder="Nội dung bạn đã nói sẽ hiển thị ở đây..." readonly></textarea>
                        <div class="input-actions">
                            <button id="clear-transcript" class="action-button" title="Xóa">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="chat-controls">
                        <div id="voice-status">Nhấn vào nút micro để bắt đầu nói</div>
                        <button id="start-voice" class="voice-button">
                            <i class="fas fa-microphone"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loading" class="loading-indicator" style="display: none;">
        <div class="spinner"></div>
        <p>Đang xử lý câu hỏi của bạn...</p>
    </div>

    <audio id="tts-audio" style="display: none;"></audio>
</div>

<style>
    :root {
        --primary-color: #4361ee;
        --primary-light: #4361ee15;
        --secondary-color: #3f37c9;
        --text-color: #333;
        --light-text: #6c757d;
        --light-bg: #f8f9fa;
        --border-color: #e9ecef;
        --success-color: #4cc9a9;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --border-radius: 16px;
        --border-radius-sm: 8px;
        --transition: all 0.3s ease;
    }

    body {
        color: var(--text-color);
    }

    .chat-container {
        display: flex;
        flex-direction: column;
        height: 70vh;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .chat-header {
        padding: 16px 20px;
        background-color: white;
        border-bottom: 1px solid var(--border-color);
    }

    .avatar-container {
        position: relative;
    }

    .avatar {
        width: 42px;
        height: 42px;
        background-color: var(--primary-light);
        color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .status {
        font-size: 12px;
        color: var(--light-text);
        display: flex;
        align-items: center;
    }

    .status-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: var(--success-color);
        border-radius: 50%;
        margin-right: 5px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: var(--light-bg);
    }

    .message {
        display: flex;
        margin-bottom: 10px;
        max-width: 85%;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .message.user {
        align-self: flex-end;
    }

    .message.assistant {
        align-self: flex-start;
    }

    .message.system {
        align-self: center;
        max-width: 90%;
    }

    .message-content {
        padding: 14px 18px;
        border-radius: var(--border-radius-sm);
        box-shadow: var(--shadow-sm);
        line-height: 1.5;
    }

    .user .message-content {
        background-color: var(--primary-color);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .assistant .message-content {
        background-color: white;
        border-bottom-left-radius: 4px;
        color: var(--text-color);
    }

    .assistant .message-content p:last-child {
        margin-bottom: 0;
    }

    .system .message-content {
        background-color: var(--light-bg);
        border: 1px solid var(--border-color);
        text-align: center;
    }

    .chat-input-area {
        padding: 16px;
        background-color: white;
        border-top: 1px solid var(--border-color);
    }

    .input-wrapper {
        position: relative;
        margin-bottom: 14px;
    }

    .chat-input {
        width: 100%;
        padding: 14px 40px 14px 16px;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        resize: none;
        min-height: 60px;
        font-size: 16px;
        transition: var(--transition);
        background-color: var(--light-bg);
    }

    .chat-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
    }

    .input-actions {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
    }

    .action-button {
        background: none;
        border: none;
        color: var(--light-text);
        cursor: pointer;
        font-size: 14px;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: var(--transition);
    }

    .action-button:hover {
        background-color: var(--border-color);
        color: var(--text-color);
    }

    .chat-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #voice-status {
        font-size: 14px;
        color: var(--light-text);
    }

    .voice-button {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .voice-button:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .voice-button:active {
        transform: translateY(0);
    }

    .voice-button.listening {
        animation: pulse 1.5s infinite;
        background-color: var(--danger-color);
    }

    .loading-indicator {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 24px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        z-index: 1000;
    }

    .spinner {
        width: 48px;
        height: 48px;
        border: 4px solid rgba(67, 97, 238, 0.2);
        border-radius: 50%;
        border-top-color: var(--primary-color);
        animation: spin 1s ease-in-out infinite;
        margin-bottom: 12px;
    }

    .vocabulary-list {
        margin-top: 16px;
        border-top: 1px solid var(--border-color);
        padding-top: 16px;
    }

    .vocabulary-list h5 {
        font-size: 16px;
        margin-bottom: 12px;
        color: var(--primary-color);
    }

    .vocabulary-item {
        background-color: white;
        border-radius: var(--border-radius-sm);
        padding: 12px 16px;
        margin-bottom: 10px;
        box-shadow: var(--shadow-sm);
        border-left: 3px solid var(--accent-color);
        transition: var(--transition);
    }

    .vocabulary-item:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .vocabulary-item strong {
        color: var(--primary-color);
    }

    .audio-controls {
        display: flex;
        align-items: center;
        margin-top: 12px;
    }

    .audio-button {
        background-color: var(--light-bg);
        color: var(--text-color);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        padding: 6px 12px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition);
    }

    .audio-button:hover {
        background-color: var(--primary-light);
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .audio-button i {
        font-size: 14px;
    }

    .tips-card {
        background-color: white;
        border-radius: var(--border-radius);
        padding: 16px 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .tips-card h5 {
        font-size: 18px;
        color: var(--text-color);
        margin-bottom: 12px;
    }

    .tips-list {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .tips-list li {
        margin-bottom: 8px;
        position: relative;
    }

    .tips-list li:last-child {
        margin-bottom: 0;
    }

    .tips-list li em {
        color: var(--primary-color);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .chat-container {
            height: 65vh;
        }
        
        .message {
            max-width: 90%;
        }
        
        .chat-input {
            font-size: 15px;
        }
        
        .chat-controls {
            flex-direction: column-reverse;
            gap: 12px;
            align-items: center;
        }
        
        #voice-status {
            text-align: center;
            margin-top: 8px;
        }
    }
</style>

<script>
    let recognition = null;
    let speechSynthesis = window.speechSynthesis;
    let lastResponseText = '';
    let audioElement = document.getElementById('tts-audio');
    let currentAudioId = null;
    let chatMessages = document.getElementById('chat-messages');
    
    // Khởi tạo Web Speech API nếu trình duyệt hỗ trợ
    if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
        recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'vi-VN';
        recognition.continuous = false;
        recognition.interimResults = true;
        
        recognition.onstart = function() {
            document.getElementById('voice-status').innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Đang lắng nghe...';
            document.getElementById('start-voice').classList.add('listening');
            document.getElementById('voice-transcript').value = '';
        };
        
        recognition.onresult = function(event) {
            const transcript = Array.from(event.results)
                .map(result => result[0])
                .map(result => result.transcript)
                .join('');
            
            document.getElementById('voice-transcript').value = transcript;
        };
        
        recognition.onend = function() {
            document.getElementById('voice-status').innerHTML = 'Nhấn vào nút micro để bắt đầu nói';
            document.getElementById('start-voice').classList.remove('listening');
            
            const transcript = document.getElementById('voice-transcript').value.trim();
            if (transcript) {
                addMessageToChat('user', transcript);
                processVoiceInput(transcript);
            }
        };
        
        recognition.onerror = function(event) {
            console.error('Lỗi nhận diện giọng nói:', event.error);
            document.getElementById('voice-status').innerHTML = `<i class="fas fa-exclamation-triangle text-warning me-2"></i>Lỗi: ${event.error}. Vui lòng thử lại`;
            document.getElementById('start-voice').classList.remove('listening');
        };
    } else {
        document.getElementById('voice-status').innerHTML = '<i class="fas fa-times-circle text-danger me-2"></i>Trình duyệt không hỗ trợ nhận diện giọng nói';
        document.getElementById('start-voice').disabled = true;
    }
    
    // Xử lý nút nhận diện giọng nói
    document.getElementById('start-voice').addEventListener('click', function() {
        if (recognition) {
            try {
                recognition.start();
            } catch(e) {
                console.error('Lỗi khi bắt đầu nhận diện giọng nói:', e);
                recognition.stop();
                setTimeout(() => recognition.start(), 200);
            }
        }
    });
    
    // Xử lý nút xóa văn bản
    document.getElementById('clear-transcript').addEventListener('click', function() {
        document.getElementById('voice-transcript').value = '';
    });
    
    // Hàm thêm tin nhắn vào khung chat
    function addMessageToChat(role, content, vocabularies = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${role}`;
        
        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        
        if (role === 'assistant') {
            // Nội dung chính của tin nhắn
            messageContent.innerHTML = content;
            
            // Thêm nút phát âm thanh nếu là tin nhắn từ trợ lý
            const audioControls = document.createElement('div');
            audioControls.className = 'audio-controls';
            
            const speakButton = document.createElement('button');
            speakButton.className = 'audio-button';
            speakButton.innerHTML = '<i class="fas fa-volume-up"></i> Nghe phản hồi';
            speakButton.onclick = function() {
                if (currentAudioId) {
                    playAudioFromServer(currentAudioId);
                } else {
                    speakWithBrowser(lastResponseText);
                }
            };
            
            audioControls.appendChild(speakButton);
            messageContent.appendChild(audioControls);
            
            // Thêm danh sách từ vựng nếu có
            if (vocabularies && vocabularies.length > 0) {
                const vocabList = document.createElement('div');
                vocabList.className = 'vocabulary-list';
                
                const vocabTitle = document.createElement('h5');
                vocabTitle.innerHTML = '<i class="fas fa-book me-2"></i>Từ vựng liên quan:';
                vocabList.appendChild(vocabTitle);
                
                vocabularies.forEach(word => {
                    const vocabItem = document.createElement('div');
                    vocabItem.className = 'vocabulary-item';
                    vocabItem.innerHTML = `
                        <strong>${word.word}</strong> <span class="text-muted">${word.pronounce}</span><br>
                        <span class="meaning">${word.meaning}</span><br>
                        <span class="example"><em>Ví dụ:</em> ${word.example}</span>
                    `;
                    vocabList.appendChild(vocabItem);
                });
                
                messageContent.appendChild(vocabList);
            }
        } else {
            messageContent.textContent = content;
        }
        
        messageDiv.appendChild(messageContent);
        chatMessages.appendChild(messageDiv);
        
        // Cuộn xuống tin nhắn mới nhất
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Hàm xử lý đầu vào giọng nói
    function processVoiceInput(text) {
        if (!text) return;
        
        // Hiển thị trạng thái đang tải
        document.getElementById('loading').style.display = 'flex';
        
        // Gửi yêu cầu xử lý văn bản đến server
        fetch('{{ route("process.voice") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                query: text
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Ẩn trạng thái đang tải
            document.getElementById('loading').style.display = 'none';
            
            // Hiển thị phản hồi từ AI
            addMessageToChat('assistant', data.response, data.vocabularies);
            
            // Lưu lại text để đọc lại nếu cần
            lastResponseText = data.speech_text || stripHtml(data.response);
            
            // Tự động phát audio từ server nếu có
            if (data.audio_id) {
                currentAudioId = data.audio_id;
                playAudioFromServer(data.audio_id);
            } else {
                // Fallback to browser's speech synthesis if no audio ID
                speakWithBrowser(lastResponseText);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            document.getElementById('loading').style.display = 'none';
            addMessageToChat('assistant', '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Đã xảy ra lỗi khi xử lý yêu cầu của bạn. Vui lòng thử lại.</div>');
        });
    }
    
    // Hàm phát audio từ server
    function playAudioFromServer(audioId) {
        if (!audioElement) {
            audioElement = document.getElementById('tts-audio');
        }
        
        // Đặt nguồn audio từ route phát audio
        const audioSrc = '{{ url("play-audio") }}/' + audioId;
        
        // Chỉ tải lại nếu nguồn audio thay đổi
        if (audioElement.src !== audioSrc) {
            audioElement.src = audioSrc;
        }
        
        audioElement.controls = false;
        
        // Hiển thị thông báo đang tải audio
        const statusElement = document.getElementById('voice-status');
        const originalStatus = statusElement.innerHTML;
        statusElement.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Đang tải audio...';
        
        // Tự động phát audio sau khi tải
        audioElement.onloadeddata = function() {
            statusElement.innerHTML = '<i class="fas fa-volume-up me-2"></i>Đang phát audio...';
            audioElement.play().catch(error => {
                console.error('Lỗi khi phát audio:', error);
                statusElement.innerHTML = originalStatus;
                // Fallback to browser's speech synthesis if audio playback fails
                speakWithBrowser(lastResponseText);
            });
        };
        
        audioElement.onended = function() {
            statusElement.innerHTML = originalStatus;
        };
        
        audioElement.onerror = function() {
            console.error('Lỗi khi tải audio');
            statusElement.innerHTML = originalStatus;
            // Fallback to browser's speech synthesis if audio loading fails
            speakWithBrowser(lastResponseText);
        };
    }
    
    // Hàm loại bỏ HTML tags
    function stripHtml(html) {
        const tmp = document.createElement('DIV');
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || '';
    }
    
    // Hàm đọc văn bản bằng trình duyệt (fallback)
    function speakWithBrowser(text) {
        if (speechSynthesis && text) {
            // Dừng nếu đang nói
            speechSynthesis.cancel();
            
            // Cập nhật trạng thái
            const statusElement = document.getElementById('voice-status');
            const originalStatus = statusElement.innerHTML;
            statusElement.innerHTML = '<i class="fas fa-volume-up me-2"></i>Đang đọc...';
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'vi-VN';
            utterance.rate = 1.0;
            
            utterance.onend = function() {
                statusElement.innerHTML = originalStatus;
            };
            
            utterance.onerror = function() {
                statusElement.innerHTML = originalStatus;
            };
            
            speechSynthesis.speak(utterance);
        }
    }
    
    // Tự động cuộn xuống tin nhắn mới nhất khi trang tải xong
    window.addEventListener('load', function() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>
@endsection