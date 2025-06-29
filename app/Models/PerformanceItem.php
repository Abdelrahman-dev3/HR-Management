<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceItem extends Model
{
    protected $fillable = [
        'performance_id', 'criteria_id', 'score', 'comment'
    ];

    public function performance()
    {
        return $this->belongsTo(Performance::class);
    }

    public function criteria()
    {
        return $this->belongsTo(PerformanceCriteria::class, 'criteria_id');
    }
}
