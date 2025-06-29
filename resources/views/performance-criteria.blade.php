@extends('layout.main')

@section('title','Performance Criteria')

@section('content')
<div class="container my-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0">Performance Criteria Management</h3>
      <a href="{{ route('criteria.add') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Add Criteria
      </a>
    </div>
    <!-- Performance Criteria Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Criteria Name</th>
            <th>Description</th>
            <th>Created Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($performanceCriteria as $item)
          <tr>
            <td>
              <strong>{{$item->id}}</strong><br>
            </td>
            <td>
              <strong>{{$item->name}}</strong><br>
            </td>
            <td>{{$item->description}}</td>
            <td>{{$item->created_at->format('d-m-Y')}}</td>
            <td>
              <a href="{{route('criteria.edit',$item->id)}}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
              <form class="d-inline" action="{{route('criteria.destroy', $item->id )}}" method="post">
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