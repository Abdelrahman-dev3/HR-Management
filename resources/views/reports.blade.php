@extends('layout.main')

@section('title','Reports')

@section('content')
<div class="container my-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Reports & Analytics</h3>
      <div>
        <button class="btn btn-success me-2">
          <i class="fas fa-download"></i> Export All Reports
        </button>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
      <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
          <div class="card-body text-center">
            <i class="fas fa-users fa-2x mb-2"></i>
            <h5 class="card-title">Total Employees</h5>
            <h3 class="mb-0">25</h3>
            <small>Active: 23 | Inactive: 2</small>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
          <div class="card-body text-center">
            <i class="fas fa-clock fa-2x mb-2"></i>
            <h5 class="card-title">Average Attendance</h5>
            <h3 class="mb-0">94%</h3>
            <small>This Month</small>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-warning text-dark">
          <div class="card-body text-center">
            <i class="fas fa-calendar-times fa-2x mb-2"></i>
            <h5 class="card-title">Leave Requests</h5>
            <h3 class="mb-0">12</h3>
            <small>Pending: 5 | Approved: 7</small>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
          <div class="card-body text-center">
            <i class="fas fa-star fa-2x mb-2"></i>
            <h5 class="card-title">Performance Score</h5>
            <h3 class="mb-0">8.4/10</h3>
            <small>Average Rating</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Report Categories -->
    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-users fa-3x text-primary mb-3"></i>
            <h5 class="card-title">Employee Reports</h5>
            <p class="card-text">Comprehensive reports on employee demographics, turnover, and workforce analytics.</p>
            <div class="d-grid gap-2">
              <a href="{{ route('reports.employees') }}" class="btn btn-primary">
                <i class="fas fa-chart-bar me-2"></i>View Employee Reports
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-clock fa-3x text-success mb-3"></i>
            <h5 class="card-title">Attendance Reports</h5>
            <p class="card-text">Detailed attendance tracking, late arrivals, overtime, and attendance patterns.</p>
            <div class="d-grid gap-2">
              {{-- <a href="{{ route('attendance.reports') }}" class="btn btn-success"> --}}
                <i class="fas fa-chart-line me-2"></i>View Attendance Reports
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-calendar-alt fa-3x text-warning mb-3"></i>
            <h5 class="card-title">Leave Reports</h5>
            <p class="card-text">Leave balance reports, leave patterns, and leave request analytics.</p>
            <div class="d-grid gap-2">
              <a href="{{ route('reports.leaves') }}" class="btn btn-warning text-dark">
                <i class="fas fa-chart-pie me-2"></i>View Leave Reports
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <i class="fas fa-star fa-3x text-info mb-3"></i>
            <h5 class="card-title">Performance Reports</h5>
            <p class="card-text">Performance evaluations, trends, and employee development insights.</p>
            <div class="d-grid gap-2">
              <a href="{{ route('performance.reports') }}" class="btn btn-info">
                <i class="fas fa-chart-area me-2"></i>View Performance Reports
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
  
@endsection 