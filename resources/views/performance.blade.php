@extends('layout.main')

@section('title','Performance')

@section('content')
<div class="container my-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Performance Management</h3>
      <div>
        <a href="{{ route('performance.evaluate') }}" class="btn btn-success">
          <i class="fas fa-plus"></i> Evaluate Performance
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
            <i class="fas fa-star fa-2x mb-2"></i>
            <h5 class="card-title">Excellent (90-100%)</h5>
            <h3 class="mb-0">{{$totalExcellent}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-warning text-dark">
          <div class="card-body text-center">
            <i class="fas fa-chart-line fa-2x mb-2"></i>
            <h5 class="card-title">Good (80-89%)</h5>
            <h3 class="mb-0">{{$totalGood}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
          <div class="card-body text-center">
            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
            <h5 class="card-title">Needs Improvement</h5>
            <h3 class="mb-0">{{$totalNeedsImprovement}}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Search and Filter -->
    <form class="mb-4" method="GET" action="{{route('performance')}}">
  <div class="row">
    <div class="col-md-4">
      <label for="search" class="form-label">Search Employee</label>
      <input type="text" name="search" class="form-control" id="search" placeholder="Search by name" value="{{ request('search') }}">
    </div>

    <div class="col-md-3">
          <label for="evaluation_date" class="form-label ">Evaluation Date <span class="text-danger"></span></label>
          <input name="evaluation_date" type="date" class="form-control" id="evaluation_date" value="{{request('evaluation_date')}}">
    </div>

    <div class="col-md-3">
      <label class="form-label">Rate</label>
      <select class="form-select" name="rating" >
        <option value="">All Types</option>
        <option @selected( request('rating') == 'Excellent') value="Excellent">Excellent</option>
        <option @selected( request('rating') == 'Good') value="Good">Good</option>
        <option @selected( request('rating') == 'Needs Improvement') value="Needs Improvement">Needs Improvement</option>
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
  
    <!-- Performance Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Employee</th>
            <th>Department</th>
            <th>Position</th>
            <th>Overall Score</th>
            <th>Performance Level</th>
            <th>Last Evaluation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($performances as $performance)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Avatar">
                <div>
                  <strong>{{$performance->employee->full_name}}</strong><br>
                </div>
              </div>
            </td>
            <td>{{$performance->employee->department->department}}</td>
            <td>{{$performance->employee->position->positions}}</td>
            <td>
              <div class="progress mb-1" style="height: 20px;">
                <div class="progress-bar bg-success" style="width: {{$performance->score}}%">{{rtrim(rtrim(number_format($performance->score, 2, '.', ''), '0'), '.') }}%</div>
              </div>
              <small class="text-muted">{{$performance->score / 10}}/10</small>
            </td>
            @if ($performance->rating == 'Excellent')
              <td><span class="badge bg-success">Excellent</span></td>
            @endif
            @if ($performance->rating == 'Good')
              <td><span class="badge bg-warning ">Good</span></td>
            @endif
            @if ($performance->rating == 'Needs Improvement')
              <td><span class="badge bg-danger ">Needs Improvement</span></td>
            @endif
            <td>{{$performance->evaluation_date}}</td>
            <td>
              <a href="{{ route('performance.edit', $performance->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
              <form class="d-inline" action="{{ route('performance.destroy', $performance->id) }}" method="POST">
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