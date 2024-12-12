<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\Program;
use App\Rules\UniqueProgramRank;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = 10;
        $indicators = Indicator::orderBy('id', 'desc')->paginate($limit);
        $no = $limit * ($indicators->currentPage() - 1);

        $programs = Program::where('status', 'approved')->get();

        return view('indicator.index', compact('indicators', 'no', 'programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::where('status', 'approved')->get();

        return view('indicator.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'rank' => ['required', 'integer', new UniqueProgramRank($request->program_id)],
            'target' => ['required', 'numeric'],
            'unit' => ['required', 'string']
        ]);

        Indicator::create([
            'program_id' => $request->program_id,
            'name' => $request->name,
            'description' => $request->description,
            'rank' => $request->rank,
            'target' => $request->target,
            'unit' => $request->unit,
        ]);

        $this->recalculateROCWeights($request->program_id);

        return redirect(route('indicator.index', absolute: false))->with('message', 'Indikator Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Indicator $indicator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $indicator = Indicator::findOrFail($id);
        $programs = Program::where('status', 'approved')->get();

        return view('indicator.edit', compact('indicator', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $indicator = Indicator::findOrFail($id);

        $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'rank' => ['required', 'integer', new UniqueProgramRank($request->program_id, $indicator->id)],
            'target' => ['required', 'numeric'],
            'unit' => ['required', 'string']
        ]);

        $indicator->update([
            'program_id' => $request->program_id,
            'name' => $request->name,
            'description' => $request->description,
            'rank' => $request->rank,
            'target' => $request->target,
            'unit' => $request->unit,
        ]);

        if ($request->rank != $indicator->rank) {
            $this->recalculateROCWeights($indicator->program_id);
        }

        return redirect(route('indicator.index', absolute: false))->with('message', 'Indikator Berhasil di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $indicator = Indicator::findOrFail($id);
        $programId = $indicator->program_id;

        $indicator->delete();

        $this->recalculateRanks($programId);
        $this->recalculateROCWeights($programId);

        return redirect(route('indicator.index', absolute: false))->with('message', 'Indikator Berhasil di Hapus');
    }

    /**
     * Rekalibrasi rank indikator dalam program tertentu.
     */
    protected function recalculateRanks($programId)
    {
        $indicators = Indicator::where('program_id', $programId)
                            ->orderBy('rank', 'asc')
                            ->get();

        foreach ($indicators as $index => $indicator) {
            $indicator->update(['rank' => $index + 1]);
        }
    }

    /**
     * Rekalkulasi bobot ROC berdasarkan rank.
     */
    protected function recalculateROCWeights($programId)
    {
        $indicators = Indicator::where('program_id', $programId)
                            ->orderBy('rank', 'asc')
                            ->get();

        $n = $indicators->count();
        if ($n === 0) {
            return;
        }

        foreach ($indicators as $index => $indicator) {
            $rocWeight = 0;
            for ($i = $index + 1; $i <= $n; $i++) {
                $rocWeight += 1 / $i;
            }
            $rocWeight /= $n;

            $indicator->update([
                'roc_weight' => round($rocWeight, 2),
            ]);
        }
    }

    public function filter(Request $request)
    {
        $limit = 10;
        $indicators = Indicator::where('program_id', $request->programId)->paginate($limit);
        $no = $limit * ($indicators->currentPage() - 1);

        return view('indicator._list', compact('indicators', 'no'));
    }
}
