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