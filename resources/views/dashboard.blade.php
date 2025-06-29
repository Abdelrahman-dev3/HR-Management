@extends('layout.main')

@section('title','Dashboard')

@section('content')
<div class="container-fluid my-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-tachometer-alt text-primary"></i>
                    Dashboard
                </h2>
                <div class="text-muted">
                    <i class="fas fa-calendar-alt"></i>
                    {{ now()->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات عامة -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 fw-bold">
                                Total employees
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployees }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 fw-bold">
                                Attendance today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presentToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 fw-bold">
                                Delay today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lateToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1 fw-bold">
                                Absence today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absentToday }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نسب الحضور والغياب -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie"></i>
                        Attendance and absence rates for the current month
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="progress-circle" data-percent="{{ $attendanceRate }}">
                                <div class="progress-circle-info">
                                    <h4 class="text-success">{{ $attendanceRate }}%</h4>
                                    <p class="text-muted">Attendance</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="progress-circle" data-percent="{{ $lateRate }}">
                                <div class="progress-circle-info">
                                    <h4 class="text-warning">{{ $lateRate }}%</h4>
                                    <p class="text-muted">Delay</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="progress-circle" data-percent="{{ $absentRate }}">
                                <div class="progress-circle-info">
                                    <h4 class="text-danger">{{ $absentRate }}%</h4>
                                    <p class="text-muted">Absence</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-check"></i>
                        Leave statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Approved leaves</span>
                            <span class="badge bg-success">{{ $approvedLeaves }}</span>
                        </div>
                        <div class="progress mt-1" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: {{ $approvedLeaves > 0 ? 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Pending leaves</span>
                            <span class="badge bg-warning">{{ $pendingLeaves }}</span>
                        </div>
                        <div class="progress mt-1" style="height: 5px;">
                            <div class="progress-bar bg-warning" style="width: {{ $pendingLeaves > 0 ? 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Rejected leaves</span>
                            <span class="badge bg-danger">{{ $rejectedLeaves }}</span>
                        </div>
                        <div class="progress mt-1" style="height: 5px;">
                            <div class="progress-bar bg-danger" style="width: {{ $rejectedLeaves > 0 ? 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- أفضل وأسوأ الموظفين -->
    <div class="row mb-4">
        <!-- أفضل 5 موظفين -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-trophy"></i>
                        Top 5 Employees (Highest Attendance)
                    </h6>
                </div>
                <div class="card-body">
                    @if($bestEmployees->count() > 0)
                        @foreach($bestEmployees as $index => $employeeData)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <div class="me-3">
                                <span class="badge bg-success fs-6">{{ $index + 1 }}</span>
                            </div>
                            <img src="{{ asset('uploads/' . $employeeData['employee']->employee_image) }}" 
                                 class="rounded-circle me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                 alt="Photo">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $employeeData['employee']->full_name }}</h6>
                                <small class="text-muted">{{ $employeeData['employee']->department->department }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">{{ $employeeData['attendance_rate'] }}%</div>
                                <small class="text-muted">
                                    Present: {{ $employeeData['present_days'] }} | 
                                    Late: {{ $employeeData['late_days'] }} | 
                                    Absent: {{ $employeeData['absent_days'] }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>There is not enough data to display the best employees</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- أسوأ 5 موظفين -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Worst 5 Employees (Lowest Attendance)
                    </h6>
                </div>
                <div class="card-body">
                    @if($worstEmployees->count() > 0)
                        @foreach($worstEmployees as $index => $employeeData)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <div class="me-3">
                                <span class="badge bg-danger fs-6">{{ $index + 1 }}</span>
                            </div>
                            <img src="{{ asset('uploads/' . $employeeData['employee']->employee_image) }}" 
                                 class="rounded-circle me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                 alt="Photo">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $employeeData['employee']->full_name }}</h6>
                                <small class="text-muted">{{ $employeeData['employee']->department->department }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-danger">{{ $employeeData['attendance_rate'] }}%</div>
                                <small class="text-muted">
                                    Present: {{ $employeeData['present_days'] }} | 
                                    Late: {{ $employeeData['late_days'] }} | 
                                    Absent: {{ $employeeData['absent_days'] }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>There is not enough data to show the worst employees.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات الأقسام -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-building"></i>
                        Department statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Department</th>
                                    <th>Number of employees</th>
                                    <th>Attendance rate</th>
                                    <th>Evaluation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentStats as $deptStat)
                                <tr>
                                    <td>
                                        <strong>{{ $deptStat['department']->department }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $deptStat['employee_count'] }}</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            @if($deptStat['attendance_rate'] >= 90)
                                                <div class="progress-bar bg-success" style="width: {{ $deptStat['attendance_rate'] }}%">
                                                    {{ $deptStat['attendance_rate'] }}%
                                                </div>
                                            @elseif($deptStat['attendance_rate'] >= 70)
                                                <div class="progress-bar bg-warning" style="width: {{ $deptStat['attendance_rate'] }}%">
                                                    {{ $deptStat['attendance_rate'] }}%
                                                </div>
                                            @else
                                                <div class="progress-bar bg-danger" style="width: {{ $deptStat['attendance_rate'] }}%">
                                                    {{ $deptStat['attendance_rate'] }}%
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($deptStat['attendance_rate'] >= 90)
                                            <span class="badge bg-success">ممتاز</span>
                                        @elseif($deptStat['attendance_rate'] >= 70)
                                            <span class="badge bg-warning">جيد</span>
                                        @else
                                            <span class="badge bg-danger">ضعيف</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.progress-circle {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.progress-circle-info {
    background: white;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.border-left-success {
    border-left: 4px solid #1cc88a !important;
}

.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}

.border-left-danger {
    border-left: 4px solid #e74a3b !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}
</style>
@endsection

@section('script')
<script>
    // تحديث دوائر التقدم
    document.addEventListener('DOMContentLoaded', function() {
        const circles = document.querySelectorAll('.progress-circle');
        circles.forEach(circle => {
            const percent = parseFloat(circle.getAttribute('data-percent')) || 0;
            let color;
            
            if (percent >= 90) {
                color = '#28a745'; // أخضر
            } else if (percent >= 70) {
                color = '#ffc107'; // أصفر
            } else {
                color = '#dc3545'; // أحمر
            }
            
            circle.style.background = `conic-gradient(
                ${color} 0deg ${percent * 3.6}deg,
                #e9ecef ${percent * 3.6}deg 360deg
            )`;
        });
    });

    // إشعارات
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