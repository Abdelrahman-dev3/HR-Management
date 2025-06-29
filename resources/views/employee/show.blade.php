    @extends('layout.main')

    @section('title','Show Performance')

    @section('content')
    <div class="container py-5">
        <div class="card-body text-center">

            <!-- Employee Image -->
            <img src="https://randomuser.me/api/portraits/men/75.jpg"class="rounded-circle border border-primary"style="width: 13%;" alt="Employee Photo">
            <!-- Employee Info -->
            <h3 class="mt-3">{{$employee->full_name}}</h3>
            <div class="row">
            <div class="col-md-4 mb-2">
                <p class="text-muted mb-1"><strong>Email:</strong> {{$employee->email}}</p>
                <hr>
            </div>
            <div class="col-md-4 mb-2">
                <p class="text-muted mb-1"><strong>Department:</strong> {{$employee->department->department}}</p>
                <hr>
            </div>
            <div class="col-md-4 mb-2">
                <p class="text-muted mb-1"><strong>Position:</strong> {{$employee->position->positions}}</p>
                <hr>
            </div>
            <div class="col-md-4 mb-2">
                <p class="text-muted mb-1"><strong>Salary:</strong> ${{$employee->salary}}</p>
            </div>
            <div class="col-md-4 mb-2">
                <p class="text-muted mb-1"><strong>Phone:</strong> {{$employee->phone_number}}</p>
            </div>
            <div class="col-md-4 mb-2">
                <p class="text-muted mb-1"><strong>Address:</strong> {{$employee->address}}</p>
            </div>
            </div>


    <!-- بيانات الحضور Attendance -->
    <div class="card p-4 mb-4">
        <h4 class="section-title">Attendance</h4>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-white">
            <tr>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($attendances as $attendance)
            <tr>
                <td>{{$attendance->check_in}}</td>
                <td>{{$attendance->check_out}}</td>
                <td>{{$attendance->status}}</td>
                <td>{{$attendance->notes}}</td>
                <td>{{$attendance->date}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <!-- بيانات الإجازات Leave Information -->
    <div class="card p-4 mb-4">
        <h4 class="section-title">Leave Information</h4>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-white">
            <tr>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($leaves as $leave)
            <tr>
                <td>{{$leave->leaveType->name}}</td>
                <td>{{$leave->start_date}}</td>
                <td>{{$leave->end_date}}</td>
                <td>{{$leave->duration}}</td>
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
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <!-- بيانات الأداء Performance Details -->
    <div class="card p-4 mb-4">
        <h4 class="section-title">Performance Details</h4>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-white">
            <tr>
                <th>Evaluation Date</th>
                <th>Period Start</th>
                <th>Period End</th>
                <th>Total Score</th>
                <th>Rating</th>
                <th>Over Comment</th>
                <th>Criteria</th>
                <th>Score</th>
                <th>Comment</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($performances as $performance)
            @php
            $performancesItems = App\Models\PerformanceItem::where('performance_id' , $performance->id)->get();
            $pcount = $performancesItems->count() + 1; 
            @endphp
            <tr>
                <td rowspan="{{$pcount}}">{{$performance->evaluation_date}}</td>
                <td rowspan="{{$pcount}}">{{$performance->period_start}}</td>
                <td rowspan="{{$pcount}}">{{$performance->period_end}}</td>
                <td rowspan="{{$pcount}}">{{$performance->score}}</td>
                <td rowspan="{{$pcount}}">{{$performance->rating}}</td>
                <td rowspan="{{$pcount}}">{{$performance->comment}}</td>
            </tr>
            @foreach ($performancesItems as $performancesItem)
            <tr>
                <td>{{$performancesItem->criteria->name}}</td>
                <td>{{$performancesItem->score}}</td>
                <td>{{$performancesItem->comment}}</td>
            </tr>
            @endforeach
            @endforeach
            </tbody>
        </table>
        </div>
    </div>


            <!-- Buttons -->
            <div class="mt-4">
            <a href="{{ route('performance') }}" class="btn btn-secondary me-2">Back to List</a>
            </div>

        </div>
    </div>
@endsection 

