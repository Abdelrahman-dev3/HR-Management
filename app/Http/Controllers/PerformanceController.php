<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Performance;
use App\Models\PerformanceCriteria;
use App\Models\PerformanceItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        $totalEmployee = Employee::count();
        $totalExcellent = Performance::where('rating','Excellent')->count();
        $totalGood = Performance::where('rating','Good')->count();
        $totalNeedsImprovement = Performance::where('rating','Needs Improvement')->count();
        $departments   = Department::select()->get();

        $query = Performance::with(['employee']);
        // Search by name
        if ($request->has('search') && $request->search != '') {
        $query->whereHas('employee', function ($q) use ($request) {
            $q->where('full_name', 'like', '%' . $request->search . '%');
        });
        }

        if ($request->has('evaluation_date') && $request->evaluation_date != '') {
            $query->whereDate('evaluation_date', $request->evaluation_date);
        }

        // فلترة بالتقييم (rating)
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }

        $performances = $query->get();

        return view('performance' , compact('totalEmployee' , 'totalExcellent' , 'totalGood' , 'departments' , 'totalNeedsImprovement' , 'performances'));
    }




    public function evaluate()
    {
        $employees = Employee::select()->get();
        $criterias = PerformanceCriteria::select()->get();


    $today = Carbon::today();

    $lastPerformance = Performance::orderBy('period_end', 'desc')->first();

    if (!$lastPerformance) {
        $periodStart = $today;
        $periodEnd = $today->copy()->addMonths(3)->subDay();
    } else {
        $lastStart = Carbon::parse($lastPerformance->period_start);
        $lastEnd = Carbon::parse($lastPerformance->period_end);

        if ($today->lessThan($lastEnd)) {
            $periodStart = $lastStart;
            $periodEnd = $lastEnd;
        } else {
            $periodStart = $lastEnd->copy()->addDay();
            $periodEnd = $periodStart->copy()->addMonths(3)->subDay();
        }
    }
        
        return view('performance.evaluate' , compact('employees' , 'criterias' , 'periodStart' , 'periodEnd'));
    }



    public function store(Request $request)
    {
    $request->validate([
        'employee'         => 'required',
        'evaluation_date'  => 'required|date',
        'period_start'     => 'required|date',
        'period_end'       => 'required|date',
        'scores'           => 'required|array',
        'scores.*'         => 'required|numeric|min:1|max:10',
        'comment'          => 'nullable|array',
        'comment.*'        => 'nullable|string|max:1000',
        'overall_comments' => 'nullable|string|max:2000',
    ]);
    $check = Performance::where('employee_id' , $request->employee)->first();
    if ($check) {
        return redirect()->back()->with('error', 'This employee already evaluation');
    }

    $scores = collect($request->scores);
    $averageScore = $scores->avg();

    $periodStart = Carbon::createFromFormat('Y-m-d', $request->period_start)->format('Y-m-d');
    $periodEnd = Carbon::createFromFormat('Y-m-d', $request->period_end)->format('Y-m-d');

    if ($averageScore >= 9) {
        $rating = 'Excellent';
    } elseif ($averageScore >= 8) {
        $rating = 'Good';
    } else {
        $rating = 'Needs Improvement';
    }

    $performance = Performance::create([
        'employee_id'     => $request->employee,
        'evaluation_date' => $request->evaluation_date,
        'period_start'    => $periodStart,
        'period_end'      => $periodEnd,
        'score'           => round($averageScore * 10, 2),
        'rating'          => $rating,
        'comment'         => $request->overall_comments,
    ]);

foreach ($request->scores as $criteriaId => $score) {
    PerformanceItem::create([
        'performance_id' => $performance->id,
        'criteria_id'    => $criteriaId,
        'score'          => $score,
        'comment'        => $request->comment[$criteriaId] ?? null,
    ]);
}

    return redirect()->route('performance')->with('success', 'Performance evaluation saved successfully');
    }
    

    public function destroy($performance)
    {
        Performance::destroy($performance);
        
        return redirect()->route('performance')->with('success', 'performance Deleted successfully!');
    }



    public function edit(Performance $performance)
    {
        $employees = Employee::select()->get();
        $criterias = PerformanceCriteria::select()->get();
        return view('performance.edit' , compact('employees','criterias', 'performance'));
    }



    public function update(Request $request , $performanceId)
{
    $request->validate([
        'employee'         => 'required',
        'evaluation_date'  => 'required|date',
        'period_start'     => 'required|date',
        'period_end'       => 'required|date',
        'scores'           => 'required|array',
        'scores.*'         => 'required|numeric|min:1|max:10',
        'comment'          => 'nullable|array',
        'comment.*'        => 'nullable|string|max:1000',
        'overall_comments' => 'nullable|string|max:2000',
    ]);

    $scores = collect($request->scores);
    $averageScore = $scores->avg();

    if ($averageScore >= 9) {
        $rating = 'Excellent';
    } elseif ($averageScore >= 8) {
        $rating = 'Good';
    } else {
        $rating = 'Needs Improvement';
    }

    $performance = Performance::find($performanceId);

    $performance->update([
        'employee_id'     => $request->employee,
        'evaluation_date' => $request->evaluation_date,
        'period_start'    => $request->period_start,
        'period_end'      => $request->period_end,
        'score'           => round($averageScore * 10, 2),
        'rating'          => $rating,
        'comment'         => $request->overall_comments,
    ]);
    foreach ($request->scores as $criteriaId => $score) {
        PerformanceItem::updateOrCreate(
            [
                'performance_id' => $performanceId,
                'criteria_id'    => $criteriaId,
            ],
            [
                'score'   => $score,
                'comment' => $request->comment[$criteriaId] ?? null,
            ]
        );
    }

    return redirect()->route('performance')->with('success', 'Performance evaluation updated successfully');
}

} 