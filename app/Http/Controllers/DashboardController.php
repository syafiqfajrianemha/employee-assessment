<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'manager') {
            $totalWaitingPrograms = Program::where('status', 'waiting')->count();
            return view('dashboard', compact('totalWaitingPrograms'));
        }

        if ($user->role === 'fundraising') {
            $programs = $user->assignedPrograms()->with(['indicators.performances'])->get();

            foreach ($programs as $program) {
                $programKinerja = 0;

                foreach ($program->indicators as $indicator) {
                    foreach ($indicator->performances as $performance) {
                        if (!is_null($performance->actual)) {
                            $programKinerja += $performance->final_score;
                        }
                    }
                }

                $program->hasilKinerja = $programKinerja > 0 ? $programKinerja : 0;
            }

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

            return view('dashboard', compact('programs', 'employees'));
        }

        if ($user->role === 'program') {
            $totalApprovedPrograms = Program::where('status', 'approved')->count();
            return view('dashboard', compact('totalApprovedPrograms'));
        }

        return view('dashboard');
    }
}
