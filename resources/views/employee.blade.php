@extends('layout.main')

@section('title','Employee')

@section('content')
<div class="container my-5">

    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Employees</h3>
      <a href="{{ route('employee.create') }}" class="btn btn-success">
        <i class="fas fa-user-plus"></i> Add Employee
      </a>
    </div>
  
    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Department</th>
            <th>Salary</th>
            <th>Status</th>
            <th>Date Joined</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($employyees as $employyee)
          <tr>
            <td>{{ $employyee->id }}</td>
            <td>{{ $employyee->full_name }}</td>
            <td>{{ $employyee->email }}</td>
            <td>{{ $employyee->position ? $employyee->position->positions : 'deleted' }}</td>
            <td>{{ $employyee->department ? $employyee->department->department : 'deleted' }}</td>
            <td>${{ $employyee->salary }}</td>
            <td><span class="badge bg-success">Active</span></td>
            <td>{{ $employyee->created_at->format('d/m/Y') }}</td>
            <td>
              <a href="{{route('employee.show' ,  $employyee->id)}}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
              <a href="{{route('employee.edit', $employyee->id )}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                <form class="d-inline" action="{{route('employee.destroy', $employyee->id )}}" method="post">
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