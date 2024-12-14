<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BonusController extends Controller
{
    public function showBonusQualifiedEmployees()
    {
        $employees = DB::table('users')
            ->join('performances', 'users.id', '=', 'performances.user_id')
            ->join('programs', 'performances.program_id', '=', 'programs.id') // Join ke tabel programs
            ->select(
                'users.id',
                'users.name',
                'users.salary',
                'programs.name as program_name', // Nama program
                DB::raw('SUM(performances.final_score) as total_final_score') // Total skor
            )
            ->where('users.role', 'fundraising') // Filter hanya role fundraising
            ->groupBy('users.id', 'users.name', 'users.salary', 'programs.name') // Group per program
            ->havingRaw('SUM(performances.final_score) > 100') // Hanya tampilkan yang > 100%
            ->get();

        // Hitung bonus berdasarkan kelebihan skor
        $employees->transform(function ($employee) {
            $excess_percentage = $employee->total_final_score - 100; // Lebihan dari 100%
            $employee->bonus = $employee->salary * ($excess_percentage / 100); // Hitung bonus
            return $employee;
        });

        return view('bonus.index', compact('employees'));
    }
}
