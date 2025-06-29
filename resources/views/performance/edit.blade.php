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
                    <form method="POST" action="{{route('performance.update' , $performance->id)}}">
                        @csrf
                        @method('PUT')
                        <!-- Employee Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="employee" class="form-label fw-bold">Select Employee <span class="text-danger">*</span></label>
                                <select name="employee" class="form-select" id="employee" required>
                                    <option selected disabled>Choose Employee</option>
                                        @foreach ($employees as $employee)
                                            <option @selected( $performance->employee_id == $employee->id) value="{{$employee->id}}">{{$employee->full_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="evaluation_date" class="form-label fw-bold">Evaluation Date <span class="text-danger">*</span></label>
                                <input name="evaluation_date" value="{{$performance->evaluation_date}}" type="date" class="form-control" id="evaluation_date" required>
                            </div>
                        </div>

                        <!-- Evaluation Period -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="period_start" class="form-label fw-bold">Period Start <span class="text-danger">*</span></label>
                                <input name="period_start" value="{{$performance->period_start}}" readonly type="text" class="form-control" id="period_start" required>
                            </div>
                            <div class="col-md-6">
                                <label for="period_end" class="form-label fw-bold">Period End <span class="text-danger">*</span></label>
                                <input name="period_end" value="{{$performance->period_end}}" readonly type="text"  class="form-control" id="period_end" required>
                            </div>
                        </div>

                        <!-- Performance Criteria Evaluation -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Performance Criteria Evaluation</h5>
                            
                            <!-- Technical Skills -->
                            @php
                                $PerformanceItem = App\Models\PerformanceItem::with('performance' , 'criteria')->where( 'performance_id' , $performance->id)->select()->get();
                            @endphp
                            @foreach ($PerformanceItem as $item)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">{{$item->criteria->id}}. {{$item->criteria->name}}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="text-muted">{{$item->criteria->description}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <select  name="scores[{{ $item->criteria_id }}]" class="form-select">
                                                <option selected disabled>Select Score</option>
                                                <option @selected( $item->score == 10) value="10">10 - Excellent</option>
                                                <option @selected( $item->score == 9) value="9">9 - Very Good</option>
                                                <option @selected( $item->score == 8) value="8">8 - Good</option>
                                                <option @selected( $item->score == 7) value="7">7 - Satisfactory</option>
                                                <option @selected( $item->score == 6) value="6">6 - Below Average</option>
                                                <option @selected( $item->score == 5) value="5">5 - Poor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <textarea name="comment[{{ $item->criteria->id }}]" class="form-control" rows="2" placeholder="Comments on {{ $item->criteria->name }} skills..."> {{ $item->comment }} </textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        <!-- Overall Comments -->
                        <div class="mb-4">
                            <label for="overall_comments" class="form-label fw-bold">Overall Comments</label>
                            <textarea name="overall_comments" class="form-control" id="overall_comments" rows="4" placeholder="Provide overall feedback and recommendations...">{{$performance->comment}}</textarea>
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