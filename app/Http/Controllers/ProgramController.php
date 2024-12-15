<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $limit = 10;
        $programs = Program::paginate($limit);
        $no = $limit * ($programs->currentPage() - 1);

        foreach ($programs as $program) {
            $startDate = Carbon::parse($program->start_date);
            $endDate = Carbon::parse($program->end_date);
            $days = $startDate->diffInDays($endDate);

            $program->duration = "{$days} hari";
        }

        return view('program.index', compact('programs', 'no'));
    }

    public function create()
    {
        return view('program.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'purpose' => ['required'],
            'description' => ['nullable'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        Program::create([
            'name' => $request->name,
            'purpose' => $request->purpose,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect(route('program.index', absolute: false))->with('message', 'Program Berhasil di Tambahkan');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);

        return view('program.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'purpose' => ['required'],
            'description' => ['nullable'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ]);

        $program = Program::findOrFail($id);

        $program->update([
            'name' => $request->name,
            'purpose' => $request->purpose,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'waiting'
        ]);

        return redirect(route('program.index', absolute: false))->with('message', 'Program Berhasil di Edit');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        $program->delete();

        return redirect(route('program.index', absolute: false))->with('message', 'Program Berhasil di Hapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required'],
        ]);

        if ($request->status === 'rejected') {
            $request->validate([
                'rejected_note' => ['required'],
            ]);
        }

        $program = Program::findOrFail($id);

        $program->update([
            'status' => $request->status,
            'rejected_note' => $request->rejected_note
        ]);

        $status = $request->status === 'approved' ? 'Disetujui' : 'Ditolak';

        return redirect(route('program.index', absolute: false))->with('message', 'Program Berhasil di ' . $status);
    }
}
