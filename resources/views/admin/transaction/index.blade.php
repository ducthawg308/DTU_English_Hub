@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-2">Quản lý giao dịch</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="#">DTU English Hub</a></li>
        <li class="breadcrumb-item active">Quản lý giao dịch</li>
    </ol>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách giao dịch
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người mua</th>
                        <th>Topic</th>
                        <th>Giá</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Người mua</th>
                        <th>Topic</th>
                        <th>Giá</th>
                        <th>Thời gian</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php $t = 0; @endphp
                    @foreach ($transactions as $transaction)
                        @php $t++; @endphp
                        <tr>
                            <td>{{ $t }}</td>
                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td>{{ $transaction->topic->name ?? 'N/A' }}</td>
                            <td>{{ number_format($transaction->price, 0, ',', '.') }}đ</td>
                            <td>{{ $transaction->purchase_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <h5><strong>Tổng tiền:</strong> {{ number_format($totalAmount, 0, ',', '.') }}đ</h5>
            </div>
        </div>
    </div>
</div>
@endsection
