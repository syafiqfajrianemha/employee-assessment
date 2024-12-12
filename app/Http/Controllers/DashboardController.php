<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'fundraising') {
            // Ambil program yang di-assign ke user
            $programs = $user->assignedPrograms()->with('indicators')->get();

            return view('dashboard', compact('programs'));
        }

        return view('dashboard');
    }
}
