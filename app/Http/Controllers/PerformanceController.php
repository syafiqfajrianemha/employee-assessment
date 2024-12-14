<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Indicator;
use App\Models\Performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assigns = Assign::all();
        return view('calculate.index', compact('assigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($userId, $programId)
    {
        $performances = Performance::where('user_id', $userId)
            ->where('program_id', $programId)
            ->with('indicator')
            ->get();

        $indicators = Indicator::where('program_id', $programId)->get();

        return view('calculate.create', compact('performances', 'indicators', 'userId', 'programId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'performances.*.user_id' => 'required|exists:users,id',
            'performances.*.program_id' => 'required|exists:programs,id',
            'performances.*.indicator_id' => 'required|exists:indicators,id',
            'performances.*.target' => 'required|numeric|min:0',
            'performances.*.actual' => 'required|numeric|min:0',
            'performances.*.score' => 'required|numeric|min:0|min:0',
            'performances.*.final_score' => 'required|numeric|min:0',
        ]);

        foreach ($validated['performances'] as $performance) {
            Performance::updateOrCreate(
                [
                    'user_id' => $performance['user_id'],
                    'program_id' => $performance['program_id'],
                    'indicator_id' => $performance['indicator_id'],
                ],
                [
                    'target' => $performance['target'],
                    'actual' => $performance['actual'],
                    'score' => $performance['score'],
                    'final_score' => $performance['final_score'],
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Performance $performance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Performance $performance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Performance $performance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Performance $performance)
    {
        //
    }
}
