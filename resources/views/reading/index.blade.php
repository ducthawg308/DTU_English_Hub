@extends('layouts.app')

@section('content')
<div class="reading-hero">
    <div class="container py-5">
        <!-- Hero Header -->
        <div class="text-center mb-5">
            <div class="hero-icon mb-4">
                <div class="book-animation">
                    <div class="book">
                        <div class="book-cover"></div>
                        <div class="book-pages">
                            <div class="page page-1"></div>
                            <div class="page page-2"></div>
                            <div class="page page-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="hero-title mb-3">
                <span class="gradient-text">Reading</span> 
                <span class="highlight-word">Mastery</span>
            </h1>
            <p class="hero-subtitle">Nâng cao kỹ năng đọc hiểu tiếng Anh với phương pháp học thông minh</p>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-5">
            <!-- VSTEP Reading Section -->
            <div class="col-lg-6">
                <div class="reading-card vstep-card">
                    <div class="card-glow vstep-glow"></div>
                    <div class="card-header-modern">
                        <div class="icon-badge vstep-badge">
                            <div class="library-icon">
                                <div class="shelf">
                                    <div class="book-spine book-1"></div>
                                    <div class="book-spine book-2"></div>
                                    <div class="book-spine book-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-category">HỆ THỐNG</div>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">Bài đọc hiểu VSTEP</h3>
                        <p class="card-description">
                            Thư viện bài đọc được phân loại theo chuẩn VSTEP từ cơ bản đến nâng cao, 
                            giúp bạn luyện tập có hệ thống và đạt điểm cao.
                        </p>

                        <div class="vstep-levels">
                            <div class="levels-header">
                                <h6><i class="fas fa-graduation-cap"></i> Chọn cấp độ của bạn</h6>
                            </div>
                            
                            <div class="levels-grid">
                                @foreach ([
                                    ['A1', 'Mới bắt đầu', '#22c55e', '🌱'],
                                    ['A2', 'Sơ cấp', '#84cc16', '🌿'],
                                    ['B1', 'Trung cấp', '#eab308', '🌻'],
                                    ['B2', 'Khá tốt', '#f97316', '🍊'],
                                    ['C1', 'Nâng cao', '#ef4444', '🔥'],
                                    ['C2', 'Thành thạo', '#8b5cf6', '👑'],
                                ] as [$level, $label, $color, $emoji])
                                    <a href="{{ route('default.reading', ['level' => $level]) }}" 
                                       class="level-button" 
                                       style="--level-color: {{ $color }}">
                                        <div class="level-emoji">{{ $emoji }}</div>
                                        <div class="level-info">
                                            <div class="level-code">{{ $level }}</div>
                                            <div class="level-name">{{ $label }}</div>
                                        </div>
                                        <div class="level-arrow">→</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Reading Section -->
            <div class="col-lg-6">
                <div class="reading-card ai-card">
                    <div class="card-glow ai-glow"></div>
                    <div class="card-header-modern">
                        <div class="icon-badge ai-badge">
                            <div class="ai-processor">
                                <div class="processor-core">
                                    <div class="core-center"></div>
                                    <div class="core-ring ring-1"></div>
                                    <div class="core-ring ring-2"></div>
                                </div>
                                <div class="data-streams">
                                    <div class="stream stream-1"></div>
                                    <div class="stream stream-2"></div>
                                    <div class="stream stream-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-category ai-category">AI POWERED</div>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">Tạo bài đọc với AI</h3>
                        <p class="card-description">
                            Trí tuệ nhân tạo tạo ra bài đọc cá nhân hóa theo sở thích và trình độ của bạn, 
                            mang đến trải nghiệm học tập độc đáo và thú vị.
                        </p>

                        <div class="ai-features">
                            <div class="feature-highlight">
                                <div class="feature-icon">⚡</div>
                                <div class="feature-text">
                                    <strong>Tạo tức thì</strong>
                                    <span>Bài đọc mới trong vài giây</span>
                                </div>
                            </div>
                            
                            <div class="feature-highlight">
                                <div class="feature-icon">🎯</div>
                                <div class="feature-text">
                                    <strong>Cá nhân hóa</strong>
                                    <span>Phù hợp với sở thích riêng</span>
                                </div>
                            </div>
                            
                            <div class="feature-highlight">
                                <div class="feature-icon">🧠</div>
                                <div class="feature-text">
                                    <strong>Thông minh</strong>
                                    <span>Điều chỉnh theo khả năng</span>
                                </div>
                            </div>
                        </div>

                        <div class="ai-specs">
                            <div class="spec-group">
                                <h6 class="spec-title">
                                    <i class="fas fa-layer-group"></i> Cấp độ hỗ trợ
                                </h6>
                                <div class="level-badges">
                                    @foreach(['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $level)
                                        <span class="level-badge">{{ $level }}</span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="spec-group">
                                <h6 class="spec-title">
                                    <i class="fas fa-tags"></i> Chủ đề phổ biến
                                </h6>
                                <div class="topic-tags">
                                    @foreach(['Du lịch', 'Công nghệ', 'Sức khỏe', 'Môi trường', 'Văn hóa', 'Thể thao'] as $topic)
                                        <span class="topic-tag">{{ $topic }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('ai.reading') }}" class="btn-ai-create">
                            <div class="btn-content">
                                <span class="btn-icon">🚀</span>
                                <span class="btn-text">Tạo với AI</span>
                            </div>
                            <div class="btn-shine"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero Section */
.reading-hero {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.reading-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 25% 75%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 25%, rgba(255,255,255,0.08) 0%, transparent 50%);
}

/* Hero Header */
.hero-icon {
    position: relative;
}

.book-animation {
    display: inline-block;
    animation: float 3s ease-in-out infinite;
}

.book {
    position: relative;
    width: 80px;
    height: 60px;
    margin: 0 auto;
}

.book-cover {
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #ff6b6b, #feca57);
    border-radius: 4px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.book-pages {
    position: absolute;
    right: -3px;
    top: 2px;
    width: 70px;
    height: 56px;
}

.page {
    position: absolute;
    width: 100%;
    height: 100%;
    background: white;
    border-radius: 0 4px 4px 0;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.page-1 { transform: translateX(-2px); }
.page-2 { transform: translateX(-4px); }
.page-3 { transform: translateX(-6px); }

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 1rem;
}

.gradient-text {
    background: linear-gradient(45deg, #ff6b6b, #feca57);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.highlight-word {
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255,255,255,0.9);
    font-weight: 300;
    max-width: 600px;
    margin: 0 auto;
}

/* Reading Cards */
.reading-card {
    position: relative;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.reading-card:hover {
    transform: translateY(-8px);
}

/* Card Glow Effects */
.card-glow {
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border-radius: 24px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.vstep-glow {
    background: linear-gradient(45deg, #22c55e, #84cc16, #eab308);
}

.ai-glow {
    background: linear-gradient(45deg, #8b5cf6, #3b82f6, #06b6d4);
}

.reading-card:hover .card-glow {
    opacity: 0.3;
}

/* Card Headers */
.card-header-modern {
    padding: 2rem 2rem 0;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.icon-badge {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.vstep-badge {
    background: linear-gradient(135deg, #22c55e, #84cc16);
}

.ai-badge {
    background: linear-gradient(135deg, #8b5cf6, #3b82f6);
}

/* Library Icon Animation */
.library-icon {
    color: white;
}

.shelf {
    display: flex;
    align-items: flex-end;
    justify-content: center;
    height: 40px;
}

.book-spine {
    width: 8px;
    border-radius: 2px;
    margin: 0 1px;
    animation: bookPulse 2s infinite;
}

.book-1 { height: 30px; background: #ff6b6b; animation-delay: 0s; }
.book-2 { height: 35px; background: #feca57; animation-delay: 0.3s; }
.book-3 { height: 25px; background: #48cae4; animation-delay: 0.6s; }

@keyframes bookPulse {
    0%, 100% { transform: scaleY(1); }
    50% { transform: scaleY(1.1); }
}

/* AI Processor Animation */
.ai-processor {
    position: relative;
    width: 40px;
    height: 40px;
}

.processor-core {
    position: relative;
    width: 100%;
    height: 100%;
}

.core-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    background: white;
    border-radius: 50%;
    animation: coreGlow 2s infinite;
}

.core-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 2px solid rgba(255,255,255,0.6);
    border-radius: 50%;
    animation: ringRotate 3s linear infinite;
}

.ring-1 { width: 24px; height: 24px; }
.ring-2 { width: 36px; height: 36px; animation-direction: reverse; }

@keyframes coreGlow {
    0%, 100% { box-shadow: 0 0 10px rgba(255,255,255,0.8); }
    50% { box-shadow: 0 0 20px rgba(255,255,255,1); }
}

@keyframes ringRotate {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Card Categories */
.card-category {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 1px;
    color: white;
    background: rgba(0,0,0,0.2);
    backdrop-filter: blur(10px);
}

.ai-category {
    background: linear-gradient(45deg, rgba(139,92,246,0.8), rgba(59,130,246,0.8));
}

/* Card Content */
.card-content {
    padding: 1.5rem 2rem 2rem;
}

.card-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 1rem;
}

.card-description {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 2rem;
}

/* VSTEP Levels */
.vstep-levels {
    margin-top: 2rem;
}

.levels-header {
    margin-bottom: 1.5rem;
}

.levels-header h6 {
    color: #374151;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.levels-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.8rem;
}

.level-button {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    text-decoration: none;
    color: #374151;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.level-button:hover {
    border-color: var(--level-color);
    color: var(--level-color);
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.level-emoji {
    font-size: 1.5rem;
    margin-right: 1rem;
}

.level-info {
    flex: 1;
}

.level-code {
    font-weight: 800;
    font-size: 1.1rem;
}

.level-name {
    font-size: 0.9rem;
    opacity: 0.7;
}

.level-arrow {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.level-button:hover .level-arrow {
    transform: translateX(5px);
}

/* AI Features */
.ai-features {
    margin: 2rem 0;
}

.feature-highlight {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 12px;
    margin-bottom: 1rem;
    border-left: 4px solid transparent;
    background-clip: padding-box;
    position: relative;
}

.feature-highlight::before {
    content: '';
    position: absolute;
    left: -4px;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(135deg, #8b5cf6, #3b82f6);
    border-radius: 2px;
}

.feature-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
}

.feature-text strong {
    display: block;
    font-weight: 700;
    color: #1f2937;
}

.feature-text span {
    font-size: 0.9rem;
    color: #6b7280;
}

/* AI Specs */
.ai-specs {
    margin: 2rem 0;
}

.spec-group {
    margin-bottom: 1.5rem;
}

.spec-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.level-badges, .topic-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.level-badge {
    padding: 0.3rem 0.8rem;
    background: linear-gradient(135deg, #8b5cf6, #3b82f6);
    color: white;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.topic-tag {
    padding: 0.3rem 0.8rem;
    background: #f3f4f6;
    color: #6b7280;
    border-radius: 20px;
    font-size: 0.8rem;
    border: 1px solid #e5e7eb;
}

/* AI Create Button */
.btn-ai-create {
    position: relative;
    display: block;
    width: 100%;
    padding: 1.2rem 2rem;
    background: linear-gradient(135deg, #8b5cf6, #3b82f6);
    color: white;
    text-decoration: none;
    border-radius: 16px;
    font-weight: 700;
    text-align: center;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.btn-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-icon {
    font-size: 1.2rem;
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s ease;
}

.btn-ai-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(139,92,246,0.4);
    color: white;
}

.btn-ai-create:hover .btn-shine {
    left: 100%;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .card-content {
        padding: 1rem 1.5rem 1.5rem;
    }
    
    .levels-grid {
        gap: 0.6rem;
    }
    
    .level-button {
        padding: 0.8rem 1rem;
    }
    
    .icon-badge {
        width: 60px;
        height: 60px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .card-header-modern {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
    }
}
</style>
@endsection