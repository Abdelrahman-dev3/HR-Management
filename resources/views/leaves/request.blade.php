@extends('layout.main')

@section('title','Request Leave')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-plus me-2"></i>
                        Request Leave
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('leaves.store')}}">
                        <!-- Employee Information -->
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="leave_type_id" class="form-label fw-bold">Leave Type</label>
                                <select name="leave_type_id" class="form-select" id="leave_type_id" required>
                                    <option disabled selected>Select </option>
                                    @foreach ($LeavesType as $LeaveType)
                                        <option value="{{$LeaveType->id}}">{{$LeaveType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="employee_id" class="form-label fw-bold">Employee Name<span class="text-danger">*</span></label>
                                <select name="employee_id" class="form-select" id="employee_id" required>
                                    <option disabled selected>Select Employee Name</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Date Range -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                                <input name="start_date" type="date" class="form-control" id="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
                                <input name="end_date" type="date" class="form-control" id="end_date" required>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="duration" class="form-label fw-bold">Duration (Days)</label>
                                <input name="duration" type="number" class="form-control" id="duration" min="1" max="365" readonly>
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="mb-4">
                            <label for="reason" class="form-label fw-bold">Reason for Leave <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control" id="reason" rows="4" placeholder="Please provide a detailed reason for your leave request..." required></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('leaves') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Leaves
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Submit Request
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
// Calculate duration when dates change
document.getElementById('start_date').addEventListener('change', calculateDuration);
document.getElementById('end_date').addEventListener('change', calculateDuration);

function calculateDuration() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        
        document.getElementById('duration').value = diffDays;
    }
}
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