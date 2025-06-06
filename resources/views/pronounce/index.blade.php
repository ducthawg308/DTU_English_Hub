@extends('layouts.app')

@section('content')
<div class="speaking-hero">
    <div class="container-fluid px-4">
        <!-- Animated Header -->
        <div class="hero-content text-center mb-5">
            <div class="floating-icons">
                <div class="sound-wave wave-1"></div>
                <div class="sound-wave wave-2"></div>
                <div class="sound-wave wave-3"></div>
            </div>
            <h1 class="hero-title">
                <span class="gradient-text">Speaking</span> 
                <span class="highlight-text">Mastery</span>
            </h1>
            <p class="hero-subtitle">
                Cải thiện kỹ năng Speaking với công nghệ AI tiên tiến
            </p>
        </div>

        <!-- Modern Cards Layout -->
        <div class="cards-container">
            <!-- VSTEP Speaking Card -->
            <div class="modern-card vstep-card">
                <div class="card-glow"></div>
                <div class="card-content">
                    <div class="card-header-modern">
                        <div class="icon-container vstep-icon">
                            <div class="microphone">
                                <div class="mic-body"></div>
                                <div class="mic-head">
                                    <div class="sound-indicator"></div>
                                    <div class="sound-indicator"></div>
                                    <div class="sound-indicator"></div>
                                </div>
                                <div class="mic-stand"></div>
                            </div>
                        </div>
                        <div class="card-badge">VSTEP STANDARD</div>
                    </div>
                    
                    <div class="card-body-modern">
                        <h3 class="card-title-modern">VSTEP Speaking Lab</h3>
                        <p class="card-description">Nâng cao kỹ năng nói với tiêu chuẩn VSTEP quốc tế</p>
                        
                        <div class="features-grid">
                            <div class="feature-item">
                                <div class="feature-icon">🎤</div>
                                <span>Phỏng vấn thực tế</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">🤖</div>
                                <span>Phân tích AI</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">📊</div>
                                <span>Đánh giá chi tiết</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">⚡</div>
                                <span>Phản hồi tức thì</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('pronounce.ai') }}" class="btn-modern btn-vstep">
                            <span class="btn-text">Bắt đầu luyện Speaking</span>
                            <div class="btn-effect"></div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- IPA Pronunciation Card -->
            <div class="modern-card ipa-card">
                <div class="card-glow"></div>
                <div class="card-content">
                    <div class="card-header-modern">
                        <div class="icon-container ipa-icon">
                            <div class="phonetic-symbol">
                                <div class="ipa-chart">
                                    <div class="symbol-row">
                                        <span class="phonetic-char">ə</span>
                                        <span class="phonetic-char">ɪ</span>
                                    </div>
                                    <div class="symbol-row">
                                        <span class="phonetic-char">θ</span>
                                        <span class="phonetic-char">ʃ</span>
                                    </div>
                                </div>
                                <div class="pronunciation-wave"></div>
                            </div>
                        </div>
                        <div class="card-badge ipa-badge">IPA STANDARD</div>
                    </div>
                    
                    <div class="card-body-modern">
                        <h3 class="card-title-modern">IPA Pronunciation</h3>
                        <p class="card-description">Thành thạo bảng phiên âm quốc tế với 44 âm tiết</p>
                        
                        <div class="progress-stats">
                            <div class="stat-item">
                                <div class="stat-number">44</div>
                                <div class="stat-label">Âm tiết</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">100%</div>
                                <div class="stat-label">Độ chuẩn</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">AI</div>
                                <div class="stat-label">Đánh giá</div>
                            </div>
                        </div>
                        
                        <a href="{{ route('pronounce.ipa') }}" class="btn-modern btn-ipa">
                            <span class="btn-text">Học bảng phiên âm IPA</span>
                            <div class="btn-effect"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero Section */
.speaking-hero {
    min-height: 100vh;
    background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 100%);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.speaking-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%);
}

/* Floating Sound Waves */
.floating-icons {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;
}

.sound-wave {
    position: absolute;
    border: 2px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    animation: pulse 3s infinite;
}

.wave-1 { width: 100px; height: 100px; animation-delay: 0s; }
.wave-2 { width: 160px; height: 160px; animation-delay: 1s; }
.wave-3 { width: 220px; height: 220px; animation-delay: 2s; }

@keyframes pulse {
    0% { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(1.2); opacity: 0; }
}

/* Hero Content */
.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 4rem;
    font-weight: 900;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.gradient-text {
    background: linear-gradient(45deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.highlight-text {
    color: white;
    position: relative;
}

.hero-subtitle {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    font-weight: 300;
    letter-spacing: 0.5px;
}

/* Modern Cards */
.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.modern-card {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    cursor: pointer;
}

.modern-card:hover {
    transform: translateY(-10px) rotateX(5deg);
}

/* Card Glow Effect */
.card-glow {
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
    border-radius: 24px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modern-card:hover .card-glow {
    opacity: 1;
}

/* VSTEP Card Specific */
.vstep-card .card-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    height: 100%;
}

/* IPA Card Specific */
.ipa-card .card-content {
    background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
    color: white;
    height: 100%;
}

.card-content {
    padding: 2.5rem;
    height: 500px;
    display: flex;
    flex-direction: column;
}

/* Card Header */
.card-header-modern {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.icon-container {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

/* Microphone Animation */
.microphone {
    position: relative;
    width: 40px;
    height: 40px;
}

.mic-body {
    width: 16px;
    height: 24px;
    background: rgba(255,255,255,0.9);
    border-radius: 8px 8px 0 0;
    position: absolute;
    left: 50%;
    top: 8px;
    transform: translateX(-50%);
}

.mic-head {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 12px;
    height: 16px;
    background: rgba(255,255,255,0.9);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.sound-indicator {
    width: 2px;
    height: 3px;
    background: #ff6b6b;
    margin: 1px 0;
    border-radius: 1px;
    animation: soundLevel 1.5s infinite;
}

.sound-indicator:nth-child(2) { animation-delay: 0.2s; }
.sound-indicator:nth-child(3) { animation-delay: 0.4s; }

.mic-stand {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 4px;
    background: rgba(255,255,255,0.9);
    border-radius: 2px;
}

@keyframes soundLevel {
    0%, 100% { opacity: 0.3; height: 3px; }
    50% { opacity: 1; height: 6px; }
}

/* IPA Symbol Animation */
.phonetic-symbol {
    position: relative;
    width: 40px;
    height: 40px;
}

.ipa-chart {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.symbol-row {
    display: flex;
    gap: 4px;
    margin: 2px 0;
}

.phonetic-char {
    font-size: 10px;
    font-weight: bold;
    color: rgba(255,255,255,0.9);
    animation: symbolGlow 2s infinite alternate;
}

.phonetic-char:nth-child(2) { animation-delay: 0.5s; }

.pronunciation-wave {
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #ff6b6b, transparent);
    animation: waveMove 2s infinite;
}

@keyframes symbolGlow {
    from { opacity: 0.6; }
    to { opacity: 1; }
}

@keyframes waveMove {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Card Badges */
.card-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 1px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
}

.ipa-badge {
    background: rgba(0,0,0,0.2);
}

/* Card Body */
.card-body-modern {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-title-modern {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(45deg, rgba(255,255,255,0.9), rgba(255,255,255,1));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.card-description {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    line-height: 1.6;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.1);
    padding: 0.8rem;
    border-radius: 12px;
    backdrop-filter: blur(5px);
}

.feature-icon {
    font-size: 1.2rem;
    margin-right: 0.8rem;
}

/* Progress Stats */
.progress-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(255,255,255,0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 900;
    color: white;
}

.stat-label {
    font-size: 0.8rem;
    opacity: 0.8;
    margin-top: 0.3rem;
}

/* Modern Buttons */
.btn-modern {
    position: relative;
    padding: 1rem 2rem;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-top: auto;
}

.btn-vstep {
    background: linear-gradient(45deg, #ff6b6b, #feca57);
    color: white;
}

.btn-ipa {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
}

.btn-text {
    position: relative;
    z-index: 2;
}

.btn-effect {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.btn-modern:hover .btn-effect {
    left: 100%;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .cards-container {
        grid-template-columns: 1fr;
        gap: 2rem;
        padding: 0 1rem;
    }
    
    .card-content {
        padding: 2rem;
        height: 450px;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .card-content {
        padding: 1.5rem;
        height: 400px;
    }
}
</style>
@endsection