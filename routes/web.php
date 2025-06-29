<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PerformanceCriteriaController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;

Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/',[LoginController::class,'chack'])->name('login.chack');

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

Route::get('/profile',[ProfileController::class,'index'])->name('profile');



Route::get('/positions',[PositionController::class,'index'])->name('position.index');
Route::post('/positions',[PositionController::class,'store'])->name('position.store');
Route::delete('/positions/{position}',[PositionController::class,'destroy'])->name('position.destroy');
Route::put('/positions/update',[PositionController::class,'update'])->name('position.update');





Route::get('/departments',[DepartmentController::class,'index'])->name('department.index');
Route::post('/departments',[DepartmentController::class,'store'])->name('department.store');
Route::delete('/departments/{department}',[DepartmentController::class,'destroy'])->name('department.destroy');
Route::put('/departments/update',[DepartmentController::class,'update'])->name('department.update');




Route::get('/employees',[EmployeeController::class,'index'])->name('employee');
Route::get('/employees/add',[EmployeeController::class,'create'])->name('employee.create');
Route::post('/employees',[EmployeeController::class,'store'])->name('employee.store');
Route::delete('/employees/{employee}',[EmployeeController::class,'destroy'])->name('employee.destroy');
Route::get('/employees/{employee}/edit',[EmployeeController::class,'edit'])->name('employee.edit');
Route::get('/employees/{employee}/show',[EmployeeController::class,'show'])->name('employee.show');
Route::put('/employees/{employee}/update',[EmployeeController::class,'update'])->name('employee.update');






Route::get('/leaves',[LeaveController::class,'index'])->name('leaves');
Route::get('/leaves/request',[LeaveController::class,'request'])->name('leaves.request');
Route::post('/leaves/request',[LeaveController::class,'store'])->name('leaves.store');
Route::delete('/leaves/{leave}',[LeaveController::class,'destroy'])->name('leave.destroy');
Route::get('/leaves/{leave}/edit',[LeaveController::class,'edit'])->name('leave.edit');
Route::put('/leaves/update',[LeaveController::class,'update'])->name('leave.update');





Route::get('/leaves/balances',[LeaveController::class,'balances'])->name('leaves.balances');
Route::get('/leaves/balances/add',[LeaveController::class,'addBalance'])->name('leaves.balances.add');






Route::get('/attendance',[AttendanceController::class,'index'])->name('attendance');
Route::get('/attendance/add',[AttendanceController::class,'add'])->name('attendance.add');
Route::post('/attendance/add',[AttendanceController::class,'store'])->name('attendance.store');
Route::delete('/attendance/{attendance}',[AttendanceController::class,'destroy'])->name('attendance.destroy');
Route::get('/attendance/{attendance}/edit',[AttendanceController::class,'edit'])->name('attendance.edit');
Route::put('/attendance/{attendance}',[AttendanceController::class,'update'])->name('attendance.update');






Route::get('/performance-criteria',[PerformanceCriteriaController::class,'index'])->name('criteria');
Route::get('/performance-criteria/add',[PerformanceCriteriaController::class,'add'])->name('criteria.add');
Route::post('/performance-criteria/store',[PerformanceCriteriaController::class,'store'])->name('criteria.store');
Route::delete('/performance-criteria/{criteria}',[PerformanceCriteriaController::class,'destroy'])->name('criteria.destroy');
Route::get('/performance-criteria/{criteria}/edit',[PerformanceCriteriaController::class,'edit'])->name('criteria.edit');
Route::put('/performance-criteria/{criteria}/update',[PerformanceCriteriaController::class,'update'])->name('criteria.update');





Route::get('/performance',[PerformanceController::class,'index'])->name('performance');
Route::get('/performance/evaluate',[PerformanceController::class,'evaluate'])->name('performance.evaluate');
Route::post('/performance/evaluate/store',[PerformanceController::class,'store'])->name('performance.store');
Route::delete('/performance/{performance}/destroy',[PerformanceController::class,'destroy'])->name('performance.destroy');
Route::get('/performance/{performance}/edit',[PerformanceController::class,'edit'])->name('performance.edit');
Route::put('/performance/{performanceId}/update',[PerformanceController::class,'update'])->name('performance.update');

});