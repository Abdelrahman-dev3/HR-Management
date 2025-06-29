@extends('layout.main')

@section('title','Evaluate Performance')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-star me-2"></i>
                        Performance Evaluation
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('performance.store')}}">
                        @csrf
                        <!-- Employee Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="employee" class="form-label fw-bold">Select Employee <span class="text-danger">*</span></label>
                                <select name="employee" class="form-select" id="employee" required>
                                    <option selected disabled>Choose Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="evaluation_date" class="form-label fw-bold">Evaluation Date <span class="text-danger">*</span></label>
                                <input name="evaluation_date" type="date" class="form-control" id="evaluation_date" required>
                            </div>
                        </div>

                        <!-- Evaluation Period -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="period_start" class="form-label fw-bold">Period Start <span class="text-danger">*</span></label>
                                <input name="period_start" readonly type="text" value="{{$periodStart->format('Y-m-d')}}" class="form-control" id="period_start" required>
                            </div>
                            <div class="col-md-6">
                                <label for="period_end" class="form-label fw-bold">Period End <span class="text-danger">*</span></label>
                                <input name="period_end" readonly type="text" value="{{$periodEnd->format('Y-m-d')}}" class="form-control" id="period_end" required>
                            </div>
                        </div>

                        <!-- Performance Criteria Evaluation -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Performance Criteria Evaluation</h5>
                            
                            <!-- Technical Skills -->
                            @foreach ($criterias as $criteria)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">{{$criteria->id}}. {{$criteria->name}}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="text-muted">{{$criteria->description}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <select  name="scores[{{ $criteria->id }}]" class="form-select">
                                                <option selected disabled>Select Score</option>
                                                <option value="10">10 - Excellent</option>
                                                <option value="9">9 - Very Good</option>
                                                <option value="8">8 - Good</option>
                                                <option value="7">7 - Satisfactory</option>
                                                <option value="6">6 - Below Average</option>
                                                <option value="5">5 - Poor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <textarea name="comment[{{ $criteria->id }}]" class="form-control" rows="2" placeholder="Comments on technical skills..."></textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        <!-- Overall Comments -->
                        <div class="mb-4">
                            <label for="overall_comments" class="form-label fw-bold">Overall Comments</label>
                            <textarea name="overall_comments" class="form-control" id="overall_comments" rows="4" placeholder="Provide overall feedback and recommendations..."></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('performance') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Performance
                            </a>
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>
                                    Save Evaluation
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
// Set default dates
document.getElementById('evaluation_date').value = new Date().toISOString().split('T')[0];

    document.addEventListener("DOMContentLoaded", function () {
        const startInput = document.getElementById("period_start");
        const endInput = document.getElementById("period_end");

        startInput.addEventListener("change", function () {
            const startDate = new Date(startInput.value);

            if (!isNaN(startDate)) {
                const endDate = new Date(startDate);
                endDate.setMonth(endDate.getMonth() + 3);
                endInput.value = endDate.toISOString().split('T')[0];
            }
        });
    });

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