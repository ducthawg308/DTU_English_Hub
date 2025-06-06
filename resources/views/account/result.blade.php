@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Page Title -->
    <h1 class="mb-5 text-center display-5 fw-bold text-primary">
        <i class="bi bi-bar-chart-line me-2"></i>Tổng quan kết quả học tập
    </h1>

    <!-- Goal Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold text-success">
                <i class="bi bi-bullseye me-2"></i>Mục tiêu của bạn
            </h5>

            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($user->target_level)
                <p class="card-text mb-1 fs-5">
                    <strong>VSTEP {{ $user->target_level }}</strong>
                </p>
                @if($user->target_deadline)
                    <small class="text-muted">Hoàn thành trước: {{ $user->target_deadline }}</small>
                @endif
                <form action="{{ route('account.set-target') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-4">
                            <select name="target_level" class="form-select" required>
                                <option value="">Chọn mức</option>
                                @foreach(['3' => 'B1', '4' => 'B2', '5' => 'C1'] as $value => $label)
                                    <option value="{{ $value }}" {{ $user->target_level == $value ? 'selected' : '' }}>
                                        VSTEP {{ $value }} ({{ $label }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="target_deadline" class="form-control" value="{{ $user->target_deadline }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-success w-100">
                                Cập nhật mục tiêu
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route('account.set-target') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-4">
                            <select name="target_level" class="form-select" required>
                                <option value="">Chọn mức</option>
                                @foreach(['3' => 'B1', '4' => 'B2', '5' => 'C1'] as $value => $label)
                                    <option value="{{ $value }}">VSTEP {{ $value }} ({{ $label }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="target_deadline" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100">
                                Lưu mục tiêu
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            <hr class="my-3">

            <p class="mb-0">
                <i class="bi bi-bar-chart-fill text-primary me-1"></i>
                <strong>Bạn đang ở:</strong>
                <span class="fw-bold text-primary">{{ $currentLevel }}</span>
            </p>
        </div>
    </div>

    <!-- Skill Charts -->
    <div class="row">
        <!-- Radar Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold text-primary">
                        <i class="bi bi-graph-up me-2"></i>Biểu đồ điểm trung bình
                    </h5>
                    <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                        <canvas id="skillRadarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold text-primary">
                        <i class="bi bi-bar-chart me-2"></i>Tiến trình điểm số
                    </h5>
                    <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                        <canvas id="skillBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Suggestion Alert -->
    <div class="alert alert-warning shadow-sm mb-4" role="alert">
        <div class="d-flex">
            <i class="bi bi-lightbulb-fill text-warning me-3 fs-4"></i>
            <div class="flex-grow-1 w-100">
                <strong>Gợi ý:</strong>
                Bạn nên luyện thêm kỹ năng 
                <span id="weakSkill" class="text-danger fw-bold">{{ ucfirst($weakestSkill ?? 'Chưa xác định') }}</span>.
                
                @if (!empty($weakTopics))
                    <div class="mt-3">
                        <p class="mb-2">Các chủ đề cần cải thiện:</p>
                        <ul class="list-unstyled">
                            @foreach($weakTopics as $topic)
                                <li class="d-flex align-items-center border-bottom py-2">
                                    <span class="flex-grow-1">{{ $topic }}</span>
                                    @php
                                        // Determine route based on weakest skill
                                        $practiceRoute = '#';
                                        $skillParam = strtolower($weakestSkill ?? '');
                                        
                                        switch($skillParam) {
                                            case 'listening':
                                                $practiceRoute = route('listening.ai', ['topic' => $topic, 'level' => $user->target_level ?? 3]);
                                                break;
                                            case 'reading':
                                                $practiceRoute = route('ai.reading', ['topic' => $topic, 'level' => $user->target_level ?? 3]);
                                                break;
                                            case 'writing':
                                                $practiceRoute = route('index.writing', ['topic' => $topic, 'level' => $user->target_level ?? 3]);
                                                break;
                                            case 'speaking':
                                                $practiceRoute = route('pronounce.ai', ['topic' => $topic, 'level' => $user->target_level ?? 3]);
                                                break;
                                        }
                                    @endphp
                                    <a href="{{ $practiceRoute }}" class="btn btn-sm btn-primary ms-auto">Luyện ngay</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="mt-2 mb-0">Chưa có dữ liệu chi tiết về chủ đề cần cải thiện.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Test History -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold text-info">
                <i class="bi bi-clock-history me-2"></i>Lịch sử bài thi thử
            </h5>
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Ngày</th>
                            <th scope="col">Nghe</th>
                            <th scope="col">Đọc</th>
                            <th scope="col">Viết</th>
                            <th scope="col">Nói</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $attempt)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('d/m/Y') }}</td>
                                <td class="fw-bold">{{ $attempt->listening_score }}</td>
                                <td class="fw-bold">{{ $attempt->reading_score }}</td>
                                <td class="fw-bold">{{ $attempt->writing_score }}</td>
                                <td class="fw-bold">{{ $attempt->speaking_score }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scores = @json($scores);
        const history = @json($history);
        const weakestSkill = '{{ $weakestSkill ?? '' }}'.toLowerCase();
        const weakTopics = @json($weakTopics);

        // Radar Chart (Average Scores)
        const radarCtx = document.getElementById('skillRadarChart').getContext('2d');
        new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: ['Nghe', 'Đọc', 'Viết', 'Nói'],
                datasets: [{
                    label: 'Điểm trung bình',
                    data: [scores.listening, scores.reading, scores.writing, scores.speaking],
                    backgroundColor: 'rgba(25, 135, 84, 0.2)',
                    borderColor: '#198754',
                    borderWidth: 2,
                    pointBackgroundColor: '#198754',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#198754'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 10,
                        ticks: {
                            stepSize: 2,
                            backdropColor: 'transparent'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        angleLines: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        pointLabels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        // Bar Chart (Score Progression)
        const barCtx = document.getElementById('skillBarChart').getContext('2d');
        const labels = history.map(item => new Date(item.submitted_at).toLocaleDateString('vi-VN'));
        const datasets = [
            {
                label: 'Nghe',
                data: history.map(item => item.listening_score),
                backgroundColor: 'rgba(25, 135, 84, 0.6)',
                borderColor: '#198754',
                borderWidth: 1
            },
            {
                label: 'Đọc',
                data: history.map(item => item.reading_score),
                backgroundColor: 'rgba(0, 123, 255, 0.6)',
                borderColor: '#007bff',
                borderWidth: 1
            },
            {
                label: 'Viết',
                data: history.map(item => item.writing_score),
                backgroundColor: 'rgba(255, 193, 7, 0.6)',
                borderColor: '#ffc107',
                borderWidth: 1
            },
            {
                label: 'Nói',
                data: history.map(item => item.speaking_score),
                backgroundColor: 'rgba(220, 53, 69, 0.6)',
                borderColor: '#dc3545',
                borderWidth: 1
            }
        ];

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Ngày thi'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 10,
                        title: {
                            display: true,
                            text: 'Điểm'
                        },
                        ticks: {
                            stepSize: 2
                        }
                    }
                }
            }
        });
    });
</script>
@endsection