@php use App\Models\LeaveBalance; @endphp
@extends('layout.main')
@section('title','Leave Balances')

@section('content')
<div class="container my-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Leave Balances Management</h3>
    </div>


    <!-- Search and Filter -->
  <form class="mb-4" method="GET" action="{{ route('leaves.balances') }}">
  <div class="row">
    <div class="col-md-4">
      <label for="search" class="form-label">Search Employee</label>
      <input type="text" name="search" class="form-control" id="search" placeholder="Search by name" value="{{ request('search') }}">
    </div>

    <div class="col-md-3">
      <label for="department" class="form-label">Department</label>
      <select class="form-select" name="department" id="department">
        <option value="">All Departments</option>
        <option value="IT" {{ request('department') == 'IT' ? 'selected' : '' }}>IT Department</option>
        <option value="HR" {{ request('department') == 'HR' ? 'selected' : '' }}>HR Department</option>
        <option value="Finance" {{ request('department') == 'Finance' ? 'selected' : '' }}>Finance Department</option>
        <option value="Marketing" {{ request('department') == 'Marketing' ? 'selected' : '' }}>Marketing Department</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Leave Type (not active yet)</label>
      <select class="form-select" name="leave_type" disabled>
        <option value="">All Types</option>
        <option value="Annual Leave">Annual Leave</option>
        <option value="Sick Leave">Sick Leave</option>
        <option value="Emergency Leave">Emergency Leave</option>
      </select>
    </div>

    <div class="col-md-2">
      <label class="form-label">&nbsp;</label>
      <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-search"></i> Search
      </button>
    </div>
  </div>
</form>

  
    <!-- Leave Balances Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Employee</th>
            <th>Department</th>
            <th>Position</th>
            <th>Annual Leave</th>
            <th>Sick Leave</th>
            <th>Emergency Leave</th>
            <th>Maternity Leave</th>
            <th>Total Used</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($employees as $employee)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <img style="width: 46px;" src="{{ asset('uploads/' . $employee->employee_image) }}" class="rounded-circle me-2" alt="Avatar">
                <div>
                  <strong>{{ $employee->full_name}}</strong><br>
                </div>
              </div>
            </td>
            <td>{{ $employee->department ? $employee->department->department : 'deleted'}}</td>
            <td>{{ $employee->position ? $employee->position->positions : 'deleted'}}</td>
            @php
              $balances = LeaveBalance::where('employee_id', $employee->id)->get()->keyBy(function($item) {
                  return strtolower($item->leaveType->name); 
              });
              $types = ['Annual', 'Sick', 'Emergency', 'Maternity' , 'Unpaid'];
            @endphp
            @foreach ($types as $type)
                @php
                $leaveTypeId = \App\Models\LeaveType::where('name', $type . ' Leave')->value('id');
                    $balance = $balances[strtolower($type . ' Leave')] ?? null;
                    $used = \App\Models\Leave::where('employee_id', $employee->id)->where('leave_type_id', $leaveTypeId)->where('status', 'approved')->sum('duration');
                    $max = $balance?->leaveType->max_days_per_year ?? 0;
                    $remaining = $max > 0 ? ($max - $used) : 0;
                    $percent = $max > 0 ? ($used / $max) * 100 : 0;
                @endphp
                <td>
                  <div class="progress mb-1" style="height: 20px;">
                    <div class="progress-bar bg-success" style="width: {{ $percent }}%">
                      {{ $used }}/{{ $max }}
                    </div>
                  </div>
                  <small class="text-muted">{{ $remaining ? $remaining . 'days remaining' : 'Not exploited' }}</small>
                </td>
            @endforeach
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
  
@endsection 