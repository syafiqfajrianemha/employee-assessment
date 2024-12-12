<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assigns = Assign::all();
        return view('assign.index', compact('assigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Assign $assign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $assign = Assign::findOrFail($id);
        $programs = Program::where('status', 'approved')->get();
        $users = User::where('role', 'fundraising')->get();

        return view('assign.edit', compact('assign', 'programs', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $assign = Assign::findOrFail($id);

        $assign->delete();

        return redirect(route('assign.index', absolute: false))->with('message', 'Assign Berhasil di Hapus');
    }
}
