<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $fillable = [
        'employee_id',
        'evaluation_date',
        'period_start',
        'period_end',
        'score',
        'rating',
        'comment',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
