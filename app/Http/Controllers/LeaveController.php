<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $badgeColors = [
            'Annual Leave'    => 'success',
            'Sick Leave'      => 'warning',
            'Emergency Leave' => 'danger',
            'Maternity Leave' => 'info',
            'Unpaid Leave'    => 'secondary',
        ];

        $leaves = Leave::with('employee' , 'leaveType')->select()->get();

        $total     = Leave::count();
        $approved  = Leave::where('status', 'approved')->count();
        $pending   = Leave::where('status', 'pending')->count();
        $rejected  = Leave::where('status', 'rejected')->count();

        return view('leaves', compact('leaves' , 'badgeColors' , 'total' , 'approved' , 'pending' , 'rejected'));
    }



    public function request()
    {
        $employees = Employee::select()->get();
        $LeavesType = LeaveType::select()->get();
        return view('leaves.request' , compact('employees','LeavesType'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id'  => 'required',
            'employee_id'    => 'required',
            'start_date'     => 'required|date|before_or_equal:end_date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'duration'       => 'required|integer|min:1|max:365',
            'reason'         => 'required|string|max:1000',
        ]);
        
        $balance = LeaveBalance::where('employee_id', $request->employee_id)
            ->where('leave_type_id', $request->leave_type_id)
            ->first();

        if (!$balance) {
            $leaveType = LeaveType::findOrFail($request->leave_type_id);

            $balance = LeaveBalance::create([
                'employee_id' => $request->employee_id,
                'leave_type_id' => $request->leave_type_id,
                'remaining_days' => $leaveType->max_days_per_year,
            ]);
        }

        if ($balance->remaining_days < $request->duration) {
            return back()->with('error', 'Your available leave balance is insufficient for this leave type');
        }

        $balance->decrement('remaining_days', $request->duration);

        Leave::create([
            'employee_id'    => $request->employee_id,
            'leave_type_id'  => $request->leave_type_id,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'duration'       => $request->duration,
            'reason'         => $request->reason,
            'status'         => 'pending',
        ]);

        return redirect()->route('leaves')->with('success', 'Leave Added successfully!');
    }



    public function destroy($leave)
    {
        Leave::destroy($leave);
        
        return redirect()->route('leaves')->with('success', 'Leave Deleted successfully!');
    }




    public function edit(Leave $leave)
    {
        $employees = Employee::select()->get();
        $LeavesType = LeaveType::select()->get();
        return view('leaves.edit' , compact('employees','LeavesType' , 'leave'));
    }



    public function update(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'employee_id' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'required|numeric|min:1',
            'status' => 'required|in:pending,approved,rejected',
            'reason' => 'nullable|string|max:1000',
        ]);
        $leave = Leave::findOrFail($request->id); 
        $leave->update([
            'leave_type_id' => $request->leave_type_id,
            'employee_id' => $request->employee_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $request->duration,
            'status' => $request->status,
            'reason' => $request->reason,
        ]);
        return redirect()->route('leaves')->with('success', 'Leave request updated successfully');
    }



    public function balances(Request $request)
    {

        $query = Employee::with(['position', 'department', 'leaveBalances.leaveType']);

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        // Filter by department
        if ($request->has('department') && $request->department != '') {
            $query->whereHas('department', function($q) use ($request) {
                $q->where('department', $request->department);
            });
        }

        $employees = $query->get();
        $leaveTypes = LeaveType::all();

        return view('leaves.balances' , compact('employees', 'leaveTypes' ));
    }

}
