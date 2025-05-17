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
            <p class="card-text mb-1 fs-5"><strong>VSTEP B1</strong></p>
            <small class="text-muted">Hoàn thành trước: 01/09/2025</small>
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
                        <tr>
                            <td>01/05/2025</td>
                            <td class="text-success fw-bold">6.5</td>
                            <td class="text-warning fw-bold">5.0</td>
                            <td class="text-danger fw-bold">4.0</td>
                            <td class="text-warning fw-bold">5.5</td>
                        </tr>
                        <tr>
                            <td>20/04/2025</td>
                            <td class="text-success fw-bold">6.0</td>
                            <td class="text-warning fw-bold">4.5</td>
                            <td class="text-danger fw-bold">3.5</td>
                            <td class="text-warning fw-bold">5.0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Tải Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Dữ liệu cứng cho biểu đồ
        const listening = 6.5;
        const reading = 5.0;
        const writing = 4.0;
        const speaking = 5.5;

        // Khởi tạo Chart.js
        const ctx = document.getElementById('skillChart').getContext('2d');
        if (!ctx) {
            console.error('Không tìm thấy canvas với id "skillChart"');
            return;
        }

        const skillChart = new Chart(ctx, {
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
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

        // Gợi ý kỹ năng yếu nhất
        const scores = { 'Nghe': listening, 'Đọc': reading, 'Viết': writing, 'Nói': speaking };
        const weakest = Object.entries(scores).sort((a, b) => a[1] - b[1])[0];
        document.getElementById('weakSkill').textContent = weakest[0];
        document.getElementById('suggestedLink').href = '/practice/' + weakest[0].toLowerCase();
    });
</script>
@endsection