@extends('layouts.app')

@section('content')
<div class="container px-5 my-5" style="min-height: 80vh;">
    <h1 class="mt-4">Trợ lý học tiếng Anh bằng giọng nói</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">DTU English Hub</a></li>
        <li class="breadcrumb-item active">Trợ lý AI giọng nói</li>   
    </ol>

    <div class="chat-container">
        <div class="chat-messages" id="chat-messages">
            <div class="message system">
                <div class="message-content">
                    <p>Xin chào! Tôi là trợ lý học tiếng Anh của bạn. Bạn có thể hỏi tôi về từ vựng, ngữ pháp, cách phát âm hoặc bất kỳ điều gì liên quan đến tiếng Anh.</p>
                </div>
            </div>
            <!-- Messages will be added here dynamically -->
        </div>

        <div class="chat-input-area">
            <textarea id="voice-transcript" class="chat-input" placeholder="Nội dung bạn đã nói sẽ hiển thị ở đây..." readonly></textarea>
            <div class="chat-controls">
                <button id="start-voice" class="voice-button">
                    <i class="fas fa-microphone"></i>
                </button>
                <div id="voice-status">Nhấn vào nút micro để bắt đầu nói</div>
            </div>
        </div>
    </div>

    <div id="loading" class="loading-indicator" style="display: none;">
        <div class="spinner"></div>
        <p>Đang xử lý...</p>
    </div>

    <audio id="tts-audio" style="display: none;"></audio>
</div>

<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: 70vh;
        background-color: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .message {
        display: flex;
        margin-bottom: 10px;
        max-width: 80%;
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
        padding: 12px 16px;
        border-radius: 18px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .user .message-content {
        background-color: #0d6efd;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .assistant .message-content {
        background-color: white;
        border-bottom-left-radius: 4px;
    }

    .system .message-content {
        background-color: #e9ecef;
        text-align: center;
    }

    .chat-input-area {
        padding: 15px;
        background-color: white;
        border-top: 1px solid #e9ecef;
    }

    .chat-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        resize: none;
        min-height: 60px;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .chat-controls {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .voice-button {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .voice-button:hover {
        background-color: #0b5ed7;
    }

    .voice-button.listening {
        animation: pulse 1.5s infinite;
        background-color: #dc3545;
    }

    #voice-status {
        font-size: 14px;
        color: #6c757d;
    }

    .loading-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top-color: #0d6efd;
        animation: spin 1s ease-in-out infinite;
    }

    .vocabulary-list {
        margin-top: 15px;
        border-top: 1px solid #e9ecef;
        padding-top: 15px;
    }

    .vocabulary-item {
        background-color: white;
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .audio-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .audio-button {
        background-color: #0d6efd;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
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
            document.getElementById('voice-status').innerHTML = 'Đang lắng nghe...';
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
            document.getElementById('voice-status').innerHTML = 'Đã hoàn thành lắng nghe';
            document.getElementById('start-voice').classList.remove('listening');
            
            const transcript = document.getElementById('voice-transcript').value.trim();
            if (transcript) {
                addMessageToChat('user', transcript);
                processVoiceInput(transcript);
            }
        };
        
        recognition.onerror = function(event) {
            console.error('Lỗi nhận diện giọng nói:', event.error);
            document.getElementById('voice-status').innerHTML = `Lỗi: ${event.error}. Vui lòng thử lại`;
            document.getElementById('start-voice').classList.remove('listening');
        };
    } else {
        document.getElementById('voice-status').innerHTML = 'Trình duyệt của bạn không hỗ trợ nhận diện giọng nói';
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
            speakButton.innerHTML = '<i class="fas fa-volume-up"></i> Đọc lại';
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
                vocabTitle.textContent = 'Từ vựng liên quan:';
                vocabList.appendChild(vocabTitle);
                
                vocabularies.forEach(word => {
                    const vocabItem = document.createElement('div');
                    vocabItem.className = 'vocabulary-item';
                    vocabItem.innerHTML = `
                        <strong>${word.word}</strong> (${word.pronounce}): ${word.meaning} <br>
                        <em>Ví dụ:</em> ${word.example}
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
        .then(response => response.json())
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
            addMessageToChat('assistant', '<p class="text-danger">Đã xảy ra lỗi khi xử lý yêu cầu của bạn. Vui lòng thử lại.</p>');
        });
    }
    
    // Hàm phát audio từ server
    function playAudioFromServer(audioId) {
        if (!audioElement) {
            audioElement = document.getElementById('tts-audio');
        }
        
        // Đặt nguồn audio từ route phát audio
        audioElement.src = '{{ url("play-audio") }}/' + audioId;
        audioElement.controls = false;
        
        // Tự động phát audio
        audioElement.onloadedmetadata = function() {
            audioElement.play().catch(error => {
                console.error('Lỗi khi phát audio:', error);
                // Fallback to browser's speech synthesis if audio playback fails
                speakWithBrowser(lastResponseText);
            });
        };
        
        audioElement.onerror = function() {
            console.error('Lỗi khi tải audio');
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
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'vi-VN';
            utterance.rate = 1.0;
            
            speechSynthesis.speak(utterance);
        }
    }
</script>
@endsection