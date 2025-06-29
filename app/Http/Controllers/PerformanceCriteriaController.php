<?php

namespace App\Http\Controllers;

use App\Models\PerformanceCriteria;
use Illuminate\Http\Request;

class PerformanceCriteriaController extends Controller
{
    public function index()
    {
        $performanceCriteria = PerformanceCriteria::select()->get();
        return view('performance-criteria' , compact('performanceCriteria'));
    }



    public function add()
    {
        return view('performance-criteria.add');
    }



    public function store(Request $request)
    {
            $request->validate([
            'criteria'    => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        PerformanceCriteria::create([
            'name'        => $request->criteria,
            'description' => $request->description,
        ]);
        return redirect()->route('criteria')->with('success', 'Performance Criteria added successfully.');
    }



    public function destroy($id)
    {
        PerformanceCriteria::destroy($id);
        
        return redirect()->route('criteria')->with('success', 'Performance-criteria Deleted successfully!');
    }



    public function edit(PerformanceCriteria $criteria)
    {
        return view('performance-criteria.edit', compact('criteria'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'criteria'    => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $performanceCriteria = PerformanceCriteria::findOrFail($id);

        $performanceCriteria->update([
            'name'        => $request->criteria,
            'description' => $request->description,
        ]);
        return redirect()->route('criteria')->with('success', 'Performance-criteria Update successfully!');

    }

} 