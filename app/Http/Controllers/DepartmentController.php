<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::select()->get();
        
        return view('department.index', compact('departments'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255|min:2'
        ]);
        Department::create([
            'department' => $request->department_name
        ]);      
        
        return redirect()->route('department.index')->with('success', 'Department added successfully!');
    }



    public function destroy($department)
    {
        Department::destroy($department);
        
        return redirect()->route('department.index')->with('success', 'Department Deleted successfully!');
    }



    public function update(Request $request)
    {
        $request->validate([
            'Department_name' => 'required|string|max:255|min:2'
        ]);
        $department = Department::find($request->id);
        $department->department = $request->Department_name;
        $department->save();
        
        return redirect()->route('department.index')->with('success', 'Department Updated successfully!');
    }
} 