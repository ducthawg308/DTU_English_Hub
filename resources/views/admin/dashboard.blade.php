@extends('layouts.admin')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Welcome to the Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Users</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Total Sales</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Total Revenue</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Pending Orders</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Recent Activities
        </div>
        <div class="card-body">
            <table class="table table-striped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Activity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>Logged in</td>
                        <td>2023-10-01</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>Updated profile</td>
                        <td>2023-10-02</td>
                    </tr>
                    <tr>
                        <td>Mike Johnson</td>
                        <td>Made a purchase</td>
                        <td>2023-10-03</td>
                    </tr>
                    <tr>
                        <td>Emily Davis</td>
                        <td>Logged out</td>
                        <td>2023-10-04</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection