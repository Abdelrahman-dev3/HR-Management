@extends('layout.main')

@section('title','Leaves')

@section('content')
<div class="container my-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Leaves Management</h3>
      <div>
        <a href="{{ route('leaves.request') }}" class="btn btn-success">
          <i class="fas fa-plus"></i> Request Leave
        </a>
      </div>
    </div>
  
    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Employee Name</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Duration</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($leaves as $leave)
          <tr>
            <td>{{$leave->id}}</td>
            <td>{{$leave->employee->full_name}}</td>
            <td>
              @php
                  $color = $badgeColors[$leave->leaveType->name] ?? 'primary';
              @endphp
            <span class="badge bg-{{ $color }}">{{ $leave->leaveType->name }}</span>
            </td>
            <td>{{$leave->start_date}}</td>
            <td>{{$leave->end_date}}</td>
            <td>{{$leave->duration}} days</td>
            <td>{{$leave->reason}}</td>

            @if ($leave->status == 'approved')
              <td><span class="badge bg-success">Approved</span></td>
            @endif
            @if ($leave->status == 'pending')
              <td><span class="badge bg-warning text-dark">Pending</span></td>
            @endif
            @if ($leave->status == 'rejected')
              <td><span class="badge bg-danger">Rejected</span></td>
            @endif
            <td>
              <a href="{{route('leave.edit' , $leave->id )}}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
              <form class="d-inline" action="{{route('leave.destroy', $leave->id )}}" method="post">
                  @csrf
                  @method('DELETE')
              <button  class="btn btn-sm btn-danger">
                  <i class="fas fa-trash"></i>
              </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-5">
      <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
          <div class="card-body text-center">
            <i class="fas fa-calendar-check fa-2x mb-2"></i>
            <h5 class="card-title">Total Leaves</h5>
            <h3 class="mb-0">{{$total}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
          <div class="card-body text-center">
            <i class="fas fa-check-circle fa-2x mb-2"></i>
            <h5 class="card-title">Approved</h5>
            <h3 class="mb-0">{{$approved}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-warning text-dark">
          <div class="card-body text-center">
            <i class="fas fa-clock fa-2x mb-2"></i>
            <h5 class="card-title">Pending</h5>
            <h3 class="mb-0">{{$pending}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
          <div class="card-body text-center">
            <i class="fas fa-times-circle fa-2x mb-2"></i>
            <h5 class="card-title">Rejected</h5>
            <h3 class="mb-0">{{$rejected}}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection 