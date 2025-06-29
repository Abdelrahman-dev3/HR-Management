@extends('layout.main')

@section('title','Add Attendance')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add Attendance Record
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('attendance.store')}}">
                        @csrf
                        <!-- Employee Selection -->
                        <div class="mb-4">
                            <label for="employee" class="form-label fw-bold">Select Employee <span class="text-danger">*</span></label>
                            <select name="employee" class="form-select" id="employee" required>
                                <option selected disabled>Choose Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                    @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="attendance_date" class="form-label fw-bold">Attendance Date <span class="text-danger">*</span></label>
                            <input name="date" type="date" class="form-control" id="attendance_date" required>
                        </div>

                        <!-- Check In/Out Times -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label fw-bold">Check In Time <span class="text-danger">*</span></label>
                                <input name="check_in" type="time" class="form-control" id="check_in" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label fw-bold">Check Out Time</label>
                                <input name="check_out" type="time" class="form-control" id="check_out">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">Attendance Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" id="status" required>
                                <option selected disabled>Select Status</option>
                                <option value="Present">Present</option>
                                <option value="Late">Late</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">Notes</label>
                            <textarea name="notes" class="form-control" id="notes" rows="3" placeholder="Add any additional notes about the attendance..."></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('attendance') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Attendance
                            </a>
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>
                                    Save Attendance
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
document.getElementById('attendance_date').value = new Date().toISOString().split('T')[0];

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