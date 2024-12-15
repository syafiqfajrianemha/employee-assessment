<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    public function index()
    {
        $assigns = Assign::all();
        return view('assign.index', compact('assigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Assign::create([
            'program_id' => $request->program_id,
            'user_id' => $request->user_id,
        ]);

        return redirect(route('program.index', absolute: false))->with('message', 'Program Berhasil di Assign ke Karyawan Fundraising');
    }

    public function edit($id)
    {
        $assign = Assign::findOrFail($id);
        $programs = Program::where('status', 'approved')->get();
        $users = User::where('role', 'fundraising')->get();

        return view('assign.edit', compact('assign', 'programs', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $assign = Assign::findOrFail($id);

        $assign->update([
            'program_id' => $request->program_id,
            'user_id' => $request->user_id,
        ]);

        return redirect(route('assign.index', absolute: false))->with('message', 'Assign Berhasil di Edit');
    }

    public function destroy($id)
    {
        $assign = Assign::findOrFail($id);

        $assign->delete();

        return redirect(route('assign.index', absolute: false))->with('message', 'Assign Berhasil di Hapus');
    }
}
