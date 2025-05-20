@extends('layouts.teacher')

@section('content')
{{-- {{dd($pendingSubmissions);}} --}}
<div class="container-fluid px-4">
    <h1 class="mt-2">Quản lý bài nghe</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ url('teacher') }}">DTU English Hub</a></li>
        <li class="breadcrumb-item active">Chấm điểm bài nghe</li>
    </ol>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách bài nghe chờ chấm điểm
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Học viên</th>
                        <th>Bài thi</th>
                        <th>Thời gian nộp</th>
                        <th>Câu hỏi</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Học viên</th>
                        <th>Bài thi</th>
                        <th>Thời gian nộp</th>
                        <th>Câu hỏi</th>
                        <th>Hành động</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($pendingSubmissions as $submission)
                    <tr>
                        <td>{{ $submission->response_id }}</td>
                        <td>{{ $submission->student_name }}</td>
                        <td>{{ $submission->exam_title }}</td>
                        <td>{{ $submission->submitted_at }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#promptModal{{ $submission->response_id }}">
                                <i class="fa-solid fa-eye"></i> Xem
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="promptModal{{ $submission->response_id }}" tabindex="-1" aria-labelledby="promptModalLabel{{ $submission->response_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="promptModalLabel{{ $submission->response_id }}">Đề bài nghe</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {!! $submission->speaking_prompt !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('teacher.speaking.grade', $submission->response_id) }}" class="btn btn-primary btn-sm">
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