@extends('layouts.app')

@section('content')
<div class="listening-hero">
    <div class="container-fluid px-4">
        <!-- Animated Header -->
        <div class="hero-content text-center mb-5">
            <div class="floating-icons">
                <div class="sound-wave wave-1"></div>
                <div class="sound-wave wave-2"></div>
                <div class="sound-wave wave-3"></div>
            </div>
            <h1 class="hero-title">
                <span class="gradient-text">Listening</span> 
                <span class="highlight-text">Mastery</span>
            </h1>
            <p class="hero-subtitle">
                Khám phá thế giới âm thanh với trải nghiệm học tập đột phá
            </p>
        </div>

        <!-- Modern Cards Layout -->
        <div class="cards-container">
            <!-- AI Listening Card -->
            <div class="modern-card ai-card">
                <div class="card-glow"></div>
                <div class="card-content">
                    <div class="card-header-modern">
                        <div class="icon-container ai-icon">
                            <div class="ai-brain">
                                <div class="brain-core"></div>
                                <div class="neural-network">
                                    <span class="synapse s1"></span>
                                    <span class="synapse s2"></span>
                                    <span class="synapse s3"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-badge">AI POWERED</div>
                    </div>
                    
                    <div class="card-body-modern">
                        <h3 class="card-title-modern">Smart Listening Lab</h3>
                        <p class="card-description">Trí tuệ nhân tạo phân tích và cải thiện khả năng nghe của bạn</p>
                        
                        <div class="features-grid">
                            <div class="feature-item">
                                <div class="feature-icon">🎯</div>
                                <span>Phân tích chính xác</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">🚀</div>
                                <span>Học thích ứng</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">⚡</div>
                                <span>Phản hồi tức thì</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">🎧</div>
                                <span>Đa giọng điệu</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('listening.ai') }}" class="btn-modern btn-ai">
                            <span class="btn-text">Khám phá AI Lab</span>
                            <div class="btn-effect"></div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dictation Card -->
            <div class="modern-card dictation-card">
                <div class="card-glow"></div>
                <div class="card-content">
                    <div class="card-header-modern">
                        <div class="icon-container dictation-icon">
                            <div class="typewriter">
                                <div class="paper">
                                    <div class="line"></div>
                                    <div class="line"></div>
                                    <div class="line"></div>
                                </div>
                                <div class="cursor"></div>
                            </div>
                        </div>
                        <div class="card-badge dictation-badge">CLASSIC METHOD</div>
                    </div>
                    
                    <div class="card-body-modern">
                        <h3 class="card-title-modern">Dictation Studio</h3>
                        <p class="card-description">Phương pháp cổ điển giúp hoàn thiện kỹ năng chép chính tả</p>
                        
                        <div class="progress-stats">
                            <div class="stat-item">
                                <div class="stat-number">95%</div>
                                <div class="stat-label">Độ chính xác</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">12</div>
                                <div class="stat-label">Cấp độ</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">∞</div>
                                <div class="stat-label">Luyện tập</div>
                            </div>
                        </div>
                        
                        <a href="{{ route('list.topic') }}" class="btn-modern btn-dictation">
                            <span class="btn-text">Vào Studio</span>
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
.listening-hero {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.listening-hero::before {
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
    background: linear-gradient(45deg, #ff6b6b, #feca57);
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

/* AI Card Specific */
.ai-card .card-content {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    height: 100%;
}

/* Dictation Card Specific */
.dictation-card .card-content {
    background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 100%);
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

/* AI Brain Animation */
.ai-brain {
    position: relative;
    width: 40px;
    height: 40px;
}

.brain-core {
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    animation: glow 2s infinite alternate;
}

.neural-network {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.synapse {
    position: absolute;
    width: 6px;
    height: 6px;
    background: #ff6b6b;
    border-radius: 50%;
    animation: synapseFlash 1.5s infinite;
}

.s1 { top: 10px; left: 5px; animation-delay: 0s; }
.s2 { top: 25px; right: 8px; animation-delay: 0.5s; }
.s3 { bottom: 12px; left: 15px; animation-delay: 1s; }

@keyframes glow {
    from { box-shadow: 0 0 10px rgba(255,255,255,0.5); }
    to { box-shadow: 0 0 20px rgba(255,255,255,0.8); }
}

@keyframes synapseFlash {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.2); }
}

/* Typewriter Animation */
.typewriter {
    position: relative;
    width: 40px;
    height: 40px;
}

.paper {
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.9);
    border-radius: 4px;
    padding: 8px 6px;
}

.line {
    height: 2px;
    background: rgba(0,0,0,0.3);
    margin: 4px 0;
    border-radius: 1px;
}

.line:nth-child(2) { width: 80%; }
.line:nth-child(3) { width: 60%; }

.cursor {
    position: absolute;
    width: 1px;
    height: 12px;
    background: #ff6b6b;
    right: 12px;
    bottom: 10px;
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0; }
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

.dictation-badge {
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

.btn-ai {
    background: linear-gradient(45deg, #ff6b6b, #feca57);
    color: white;
}

.btn-dictation {
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