<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'remaining_days'
    ];
public function leaveType()
{
    return $this->belongsTo(LeaveType::class);
}
}