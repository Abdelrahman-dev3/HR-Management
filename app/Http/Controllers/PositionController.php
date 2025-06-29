<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::select()->get();
        return view('position.index', compact('positions'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:255|min:2'
        ]);
        Position::create([
            'positions' => $request->position_name
        ]);
        
        return redirect()->route('position.index')->with('success', 'Position added successfully!');
    }



    public function destroy($position)
    {
        Position::destroy($position);
        
        return redirect()->route('position.index')->with('success', 'Position Deleted successfully!');
    }



    public function update(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:255|min:2'
        ]);
        $position = Position::find($request->id);  // أو Position::findOrFail($id);
        $position->positions = $request->position_name;
        $position->save();
        
        return redirect()->route('position.index')->with('success', 'Position Updated successfully!');
    }
} 