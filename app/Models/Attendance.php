<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'check_in',
        'check_out',
        'status',
        'date',
        'notes'
    ];
        public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
