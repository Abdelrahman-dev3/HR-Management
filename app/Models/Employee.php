<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
protected $fillable = [
            'full_name',
            'email',
            'position_id',
            'department_id',
            'salary',
            'status',
            'phone_number',
            'address',
            'employee_image'
];

public function position() {
    return $this->belongsTo(Position::class);
}
public function department() {
    return $this->belongsTo(Department::class);
}
public function leaveBalances()
{
    return $this->hasMany(\App\Models\LeaveBalance::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}

}

