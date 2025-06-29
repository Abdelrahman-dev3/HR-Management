@extends('layout.main')

@section('title','Attendance')

@section('content')
<div class="container my-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Attendance Management</h3>
      <div>
        <a href="{{ route('attendance.add') }}" class="btn btn-success">
          <i class="fas fa-plus"></i> Add Attendance
        </a>
      </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
      <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
          <div class="card-body text-center">
            <i class="fas fa-users fa-2x mb-2"></i>
            <h5 class="card-title">Total Employees</h5>
            <h3 class="mb-0">{{$totalEmployee}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
          <div class="card-body text-center">
            <i class="fas fa-check-circle fa-2x mb-2"></i>
            <h5 class="card-title">Present Today</h5>
            <h3 class="mb-0">{{$presentToday}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-warning text-dark">
          <div class="card-body text-center">
            <i class="fas fa-clock fa-2x mb-2"></i>
            <h5 class="card-title">Late Today</h5>
            <h3 class="mb-0">{{$lateToday}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
          <div class="card-body text-center">
            <i class="fas fa-times-circle fa-2x mb-2"></i>
            <h5 class="card-title">Absent Today</h5>
            <h3 class="mb-0">{{$absentToday}}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Date Filter -->
  <form method="GET" action="">
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <label for="date_filter" class="form-label">Select Date</label>
            <input name="date" type="date" class="form-control" id="date_filter" value="{{ request('date') }}">
          </div>
          <div class="col-md-3">
            <label for="department_filter" class="form-label">Department</label>
            <select class="form-select" id="department" name="department">
              <option value="" disabled {{ request('department') ? '' : 'selected' }}>Select Department</option>
              @foreach ($departments as $department)
                <option @selected( request('department') == $department->id) value="{{$department->id}}">{{$department->department}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="status_filter" class="form-label">Status</label>
            <select name="status" class="form-select" id="status_filter">
              <option value="" disabled {{ request('status') ? '' : 'selected' }}>All Status</option>
              <option value="Present" {{ request('status') == 'Present' ? 'selected' : '' }}>Present</option>
              <option value="Late" {{ request('status') == 'Late' ? 'selected' : '' }}>Late</option>
              <option value="Absent" {{ request('status') == 'Absent' ? 'selected' : '' }}>Absent</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-search"></i> Filter
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
    <!-- Attendance Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Employee</th>
            <th>Department</th>
            <th>Date</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Notes</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($attendances as $attendance)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <img style="width: 46px;" src="{{ asset('uploads/' . $attendance->employee->employee_image) }}" class="rounded-circle me-2" alt="Avatar">
                <div>
                  <strong>{{$attendance->employee->full_name}}</strong><br>
                </div>
              </div>
            </td>
            <td>{{$attendance->employee->department->department}}</td>
            <td>{{$attendance->date}}</td>
            <td>{{$attendance->check_in}}</td>
            <td>{{$attendance->check_out}}</td>
            <td>{{$attendance->notes}}</td>
            @if ($attendance->status == 'Present')
              <td><span class="badge bg-success text-white">Present</span></td>
            @endif
            @if ($attendance->status == 'Late')
              <td><span class="badge bg-warning text-white">Late</span></td>
            @endif
            @if ($attendance->status == 'Absent')
              <td><span class="badge bg-danger text-white">Absent</span></td>
            @endif
            <td>
              <a href="{{route('attendance.edit', $attendance->id )}}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
              <form class="d-inline" action="{{route('attendance.destroy', $attendance->id )}}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i>
              </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>  
      </table>
    </div>
  </div>
  
@endsection 

@section('script')
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "timeOut": "7000",
        "extendedTimeOut": "3000"   
    };

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

@endsection 