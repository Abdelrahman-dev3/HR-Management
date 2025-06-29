@extends('layout.main')

@section('title', 'Add New Employee')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Add New Employee
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label fw-bold">Full Name *</label>
                                    <input type="text" class="form-control" 
                                           id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email *</label>
                                    <input type="email" class="form-control" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-bold">Phone Number *</label>
                                    <input type="tel" class="form-control" 
                                           id="phone" name="phone" value="{{ old('phone') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label fw-bold">Address *</label>
                                    <textarea class="form-control" 
                                              id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <!-- Job Information -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label fw-bold">Position *</label>
                                    <select class="form-select" id="position" name="position" required>
                                        <option disabled selected>Select Position</option>
                                        @foreach ($positions as $position)
                                            <option value="{{$position->id}}">{{$position->positions}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label fw-bold">Department *</label>
                                    <select class="form-select" id="department" name="department" required>
                                        <option disabled selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{$department->id}}">{{$department->department}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="salary" class="form-label fw-bold">Salary *</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" 
                                                id="salary" name="salary" value="{{ old('salary') }}" min="0" step="0.01" required>
                                        <span class="input-group-text">Dollar</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Upload Image *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Control Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('employee') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Back
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>
                                            Save Employee
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #ddd;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 8px 20px;
}

.text-primary {
    color: #0d6efd !important;
}
</style>
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