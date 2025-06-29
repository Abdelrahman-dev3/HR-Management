@extends('layout.main')

@section('title','Add Performance Criteria')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add Performance Criteria
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('criteria.store')}}">
                        @csrf
                        <!-- Criteria Name -->
                        <div class="mb-4">
                            <label for="criteria_name" class="form-label fw-bold">Criteria Name <span class="text-danger">*</span></label>
                            <input name="criteria" type="text" class="form-control" id="criteria_name" placeholder="Enter criteria name..." required>
                        </div>
                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" id="description" rows="4" placeholder="Provide a detailed description of this performance criteria..." required></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('criteria') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Criteria
                            </a>
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>
                                    Save Criteria
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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