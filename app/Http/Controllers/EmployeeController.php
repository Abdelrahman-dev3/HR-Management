<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Performance;
use App\Models\PerformanceItem;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employyees = Employee::select()->get();
        return view('employee' , ['employyees' => $employyees ]);
    }



    public function create()
    {
        $departments = Department::select()->get();
        $positions = Position::select()->get();
        return view('employee.add' , compact('departments' , 'positions'));
    }



    public function store(Request $request)
    {
        $imageName = '';
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'position'  => 'required',
            'department'=> 'required',
            'salary'    => 'required|numeric|min:0',
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string|max:500',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }

        Employee::create([
            'full_name'     => $request->full_name ,
            'email'         => $request->email ,
            'position_id'   => $request->position ,
            'department_id' => $request->department ,
            'salary'        => $request->salary ,
            'status'        => 0 ,
            'address'       => $request->address ,
            'phone_number'  => $request->phone ,
            'employee_image'=> $imageName ,
        ]);
        return redirect()->route('employee')->with('success', 'Employee added successfully!');
    }



    public function destroy($employee)
    {
        Employee::destroy($employee);
        
        return redirect()->route('employee')->with('success', 'Employee Deleted successfully!');
    }



    public function edit(Employee $employee)
    {
        $departments = Department::select()->get();
        $positions = Position::select()->get();
        return view('employee.edit' , compact('departments' , 'positions' , 'employee'));
    }



    public function update(Request $request)
    {
        $imageName = '';
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'position'  => 'required',
            'department'=> 'required',
            'salary'    => 'required|numeric|min:0',
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string|max:500',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $employee = Employee::findOrFail($request->id); 
        
        $imageName = $employee->employee_image;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }

        $employee->update([
            'full_name'     => $request->full_name ,
            'email'         => $request->email ,
            'position_id'   => $request->position ,
            'department_id' => $request->department ,
            'salary'        => $request->salary ,
            'status'        => 0 ,
            'address'       => $request->address ,
            'phone_number'  => $request->phone ,
            'employee_image'=> $imageName ,
        ]);
        return redirect()->route('employee')->with('success', 'Employee Updated successfully!');
    }

    public function show(Employee $employee)
    {
        $attendances = Attendance::where('employee_id' , $employee->id)->orderBy('date', 'desc')->get();
        $leaves = Leave::where('employee_id' , $employee->id)->orderBy('created_at', 'desc')->get();
        $performances = Performance::where('employee_id' , $employee->id)->orderBy('evaluation_date', 'desc')->get();
        return view('employee.show' , compact('employee' , 'attendances' , 'leaves' , 'performances'));
    }
}
