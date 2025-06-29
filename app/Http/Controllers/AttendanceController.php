<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function index(Request $request)
    {
    # get all departments
    $departments   = Department::select()->get();
    # data card
    $today         = Carbon::today()->toDateString();
    $totalEmployee = Employee::count();
    $presentToday  = Attendance::where('date', $today)->where('status', 'Present')->count();
    $lateToday     = Attendance::where('date', $today)->where('status', 'Late')->count();
    $absentToday   = Attendance::where('date', $today)->where('status', 'Absent')->count();
    # query
    if ($request->hasAny(['date', 'department', 'status'])) {
    $query = Attendance::query();
    if ($request->filled('date')) {
        $query->where('date', $request->date);
    }
    if ($request->filled('department')) {
        $query->whereHas('employee', function ($q) use ($request) {
            $q->where('department_id', $request->department);
        });
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    $attendances = $query->get();
    } else {
    $attendances = Attendance::select()->get();
    }

    return view('attendance' , compact('totalEmployee','presentToday' , 'lateToday' , 'absentToday','departments','attendances'));
    }



    public function add()
    {
        $employees = Employee::select()->get();
        return view('attendance.add' , compact('employees'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'employee'  => 'required',
            'date'  => 'required|date',
            'check_in'  => 'required|date_format:H:i',
            'check_out'  => 'required|date_format:H:i|after:check_in',
            'status'  => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);
        $check = Attendance::where('employee_id',$request->employee)->where('date',$request->date)->first();
        if ($check) {
            return redirect()->back()->with('error', 'Attendance already exist');
        }
        Attendance::create([
        'employee_id' => $request->employee,
        'date'        => $request->date,
        'check_in'    => $request->check_in,
        'check_out'   => $request->check_out,
        'status'      => $request->status,
        'notes'       => $request->notes,
    ]);

    return redirect()->route('attendance')->with('success', 'Attendance added successfully');
    }



    public function destroy($attendance)
    {
        Attendance::destroy($attendance);
        
        return redirect()->back()->with('success', 'Attendance Deleted successfully!');
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::select()->get();
        return view('attendance.edit' , compact('employees','attendance'));
    }



    public function update(Request $request ,$id)
    {
        $request->validate([
            'employee'  => 'required',
            'date'  => 'required|date',
            'check_in'  => 'required',
            'check_out'  => 'required|after:check_in',
            'status'    => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);

        $attendance = Attendance::findOrFail($id);

        $attendance->update([
        'employee_id' => $request->employee,
        'date'        => $request->date,
        'check_in'    => $request->check_in,
        'check_out'   => $request->check_out,
        'status'      => $request->status,
        'notes'       => $request->notes,
    ]);

    return redirect()->route('attendance')->with('success', 'Attendance Updated successfully');
    }
} 