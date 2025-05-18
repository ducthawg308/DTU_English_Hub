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

    <!-- Skill Chart -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold text-primary">
                <i class="bi bi-graph-up me-2"></i>Biểu đồ kỹ năng
            </h5>
            <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                <canvas id="skillChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Suggestion Alert -->
    <div class="alert alert-warning d-flex align-items-center justify-content-between shadow-sm mb-4" role="alert">
        <div>
            <i class="bi bi-lightbulb-fill me-2 text-warning"></i>
            <strong>Gợi ý:</strong> Bạn nên luyện thêm kỹ năng 
            <span id="weakSkill" class="text-danger fw-bold">Viết</span>.
        </div>
        <a href="/practice/writing" id="suggestedLink" class="btn btn-primary btn-sm">Luyện ngay</a>
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

        const listening = scores.listening;
        const reading = scores.reading;
        const writing = scores.writing;
        const speaking = scores.speaking;

        // Radar Chart
        const ctx = document.getElementById('skillChart').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Nghe', 'Đọc', 'Viết', 'Nói'],
                datasets: [{
                    label: 'Điểm',
                    data: [listening, reading, writing, speaking],
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

        const practiceRoutes = {
            'nghe': "{{ route('list.topic') }}",
            'đọc': "{{ route('index.reading') }}",
            'viết': "{{ route('index.writing') }}",
            'nói': "{{ route('home.pronounce') }}"
        };


        // Gợi ý kỹ năng yếu nhất
        const scoreMap = {
            'Nghe': listening,
            'Đọc': reading,
            'Viết': writing,
            'Nói': speaking
        };
        const weakest = Object.entries(scoreMap).sort((a, b) => a[1] - b[1])[0];
        const weakSkill = weakest[0]; // eg: 'Nghe'
        const weakSkillKey = weakSkill.toLowerCase(); // eg: 'nghe'

        document.getElementById('weakSkill').textContent = weakSkill;
        document.getElementById('suggestedLink').href = practiceRoutes[weakSkillKey];
    });
</script>
@endsection
