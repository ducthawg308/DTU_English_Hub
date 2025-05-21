@extends('layouts.teacher')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-2">Chấm điểm kết hợp</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('teacher') }}">DTU English Hub</a></li>
        <li class="breadcrumb-item active">Học viên chờ chấm điểm</li>
    </ol>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách học viên chờ chấm điểm
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Học viên</th>
                        <th>Bài thi</th>
                        <th>Thời gian nộp</th>
                        <th>Writing</th>
                        <th>Speaking</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Học viên</th>
                        <th>Bài thi</th>
                        <th>Thời gian nộp</th>
                        <th>Writing</th>
                        <th>Speaking</th>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($studentSubmissions as $student)
                    <tr>
                        <td>{{ $student['student_name'] }}</td>
                        <td>{{ $student['exam_title'] }}</td>
                        <td>{{ $student['submitted_at'] }}</td>
                        <td>
                            @if($student['writing_status'] === 'pending')
                                <span class="badge bg-warning">Chưa chấm</span>
                            @elseif($student['writing_status'] === 'graded')
                                <span class="badge bg-success">Đã chấm: {{ $student['writing_score'] }}</span>
                            @else
                                <span class="badge bg-secondary">Không có</span>
                            @endif
                        </td>
                        <td>
                            @if($student['speaking_status'] === 'pending')
                                <span class="badge bg-warning">Chưa chấm</span>
                            @elseif($student['speaking_status'] === 'graded')
                                <span class="badge bg-success">Đã chấm: {{ $student['speaking_score'] }}</span>
                            @else
                                <span class="badge bg-secondary">Không có</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('teacher.combined.grade', $student['user_id']) }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-pen"></i> Chấm điểm
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection