<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // إجمالي الموظفين
        $totalEmployees = Employee::count();
        //  تاريخ اليوم
        $today = Carbon::today();
        // الحضور اليوم
        $presentToday = Attendance::where('date', $today)->where('status', 'Present')->count();
        // التاخير اليوم
        $lateToday = Attendance::where('date', $today)->where('status', 'Late')->count();
        // الغياب اليوم
        $absentToday = $totalEmployees - $presentToday - $lateToday;

    
        // نسبة الحضور والغياب للشهر الحالي

        $currentMonth = Carbon::now()->startOfMonth();
        //  جبنا كل البيانات الي بتخص الشهر دا 
        $monthlyAttendances = Attendance::whereBetween('date', [$currentMonth->format('Y-m-d'),$currentMonth->copy()->endOfMonth()->format('Y-m-d')])->get();
        //  جبنا عدد الايام بتاعت الشهر دا 
        $totalWorkDays = (int) $currentMonth->diffInDays($currentMonth->copy()->endOfMonth()) + 1;
        // جبنا اجمالي الحضور المتوقع
        $totalExpectedAttendances = $totalEmployees * $totalWorkDays;
        // جبنا اجمالي الحضور الفعلي
        $totalActualAttendances = $monthlyAttendances->where('status', 'Present')->count(); // 5
        // جبنا اجمالي التاخر الفعلي
        $totalLateAttendances = $monthlyAttendances->where('status', 'Late')->count(); // 0
        // جبنا اجمالي الغياب الفعلي
        $totalAbsentAttendances = $totalExpectedAttendances - $totalActualAttendances - $totalLateAttendances;
        
        $attendanceRate = $totalExpectedAttendances > 0 ? round(($totalActualAttendances / $totalExpectedAttendances) * 100, 1) : 0;
        $lateRate = $totalExpectedAttendances > 0 ? round(($totalLateAttendances / $totalExpectedAttendances) * 100, 1) : 0;
        $absentRate = $totalExpectedAttendances > 0 ? round(($totalAbsentAttendances / $totalExpectedAttendances) * 100, 1) : 0;
        

        // إحصائيات الإجازات
        $pendingLeaves = Leave::where('status', 'Pending')->count();
        $approvedLeaves = Leave::where('status', 'Approved')->count();
        $rejectedLeaves = Leave::where('status', 'Rejected')->count();
        

        // أفضل 5 موظفين (أعلى نسبة حضور)
        $bestEmployees = Employee::with(['attendances' => function($query) use ($currentMonth) {
            $query->whereBetween('date', [$currentMonth->format('Y-m-d') , $currentMonth->copy()->endOfMonth()->format('Y-m-d')]);
        }])->get()->map(function($employee) use ($totalWorkDays) {
            $presentDays = $employee->attendances->where('status', 'Present')->count();
            $lateDays = $employee->attendances->where('status', 'Late')->count();
            $absentDays = $employee->attendances->where('status', 'Absent')->count();
            $attendanceRate = $totalWorkDays > 0 ? round((($presentDays + $lateDays) / $totalWorkDays) * 100, 2) : 0;
            
            return [
                'employee' => $employee,
                'attendance_rate' => $attendanceRate,
                'present_days' => $presentDays,
                'late_days' => $lateDays,
                'absent_days' => $absentDays
            ];
        })->sortByDesc('attendance_rate')->take(5);
    

        // أسوأ 5 موظفين (أقل نسبة حضور)
        $worstEmployees = Employee::with(['attendances' => function($query) use ($currentMonth) {
            $query->whereBetween('date', [
                $currentMonth->format('Y-m-d'),
                $currentMonth->endOfMonth()->format('Y-m-d')
            ]);
        }])->get()->map(function($employee) use ($totalWorkDays) {
            $presentDays = $employee->attendances->where('status', 'Present')->count();
            $lateDays = $employee->attendances->where('status', 'Late')->count();
            $absentDays = $employee->attendances->where('status', 'Absent')->count();
            $attendanceRate = $totalWorkDays > 0 ? round((($presentDays + $lateDays) / $totalWorkDays) * 100, 2) : 0;
            
            return [
                'employee' => $employee,
                'attendance_rate' => $attendanceRate,
                'present_days' => $presentDays,
                'late_days' => $lateDays,
                'absent_days' =>  $absentDays
            ];
        })->sortBy('attendance_rate')->take(5);
        

        // إحصائيات حسب الأقسام
        $startOfMonth = Carbon::now()->startOfMonth();

        $departmentStats = Department::with(['employees.attendances' => function($query) use ($startOfMonth) {
            $query->whereBetween('date', [
                $startOfMonth->format('Y-m-d'),
                $startOfMonth->endOfMonth()->format('Y-m-d')
            ]);
        }])->get()->map(function($department) use ($totalWorkDays) {
            $totalDeptEmployees = $department->employees->count();
            $totalDeptWorkDays = $totalDeptEmployees * $totalWorkDays;
            
            $presentDays = $department->employees->flatMap->attendances->where('status', 'Present')->count();
            $lateDays = $department->employees->flatMap->attendances->where('status', 'Late')->count();
            
            $attendanceRate = $totalDeptWorkDays > 0 ? round((($presentDays + $lateDays) / $totalDeptWorkDays) * 100, 2) : 0;
            
            return [
                'department' => $department,
                'employee_count' => $totalDeptEmployees,
                'attendance_rate' => $attendanceRate
            ];
        })->sortByDesc('attendance_rate');
        

        return view('dashboard', compact(
            'totalEmployees','presentToday','lateToday','absentToday','attendanceRate','lateRate','absentRate','bestEmployees','worstEmployees',
            'pendingLeaves','approvedLeaves','rejectedLeaves','departmentStats'));
    }
}
