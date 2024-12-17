<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BonusController extends Controller
{
    public function showBonusQualifiedEmployees()
    {
        $employees = DB::table('users')
            ->join('performances', 'users.id', '=', 'performances.user_id')
            ->join('programs', 'performances.program_id', '=', 'programs.id')
            ->select(
                'users.id',
                'users.name',
                'users.salary',
                'programs.name as program_name',
                DB::raw('SUM(performances.final_score) as total_final_score')
            )
            ->where('users.role', 'fundraising')
            ->groupBy('users.id', 'users.name', 'users.salary', 'programs.name')
            ->havingRaw('SUM(performances.final_score) > 100')
            ->get();

        $employees->transform(function ($employee) {
            $excess_percentage = $employee->total_final_score - 100;
            $employee->bonus = $employee->salary * ($excess_percentage / 100);
            return $employee;
        });

        return view('bonus.index', compact('employees'));
    }
}
