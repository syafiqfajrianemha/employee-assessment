<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Program;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

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

            $employees = User::with(['performances.program'])
                ->where('role', 'fundraising')
                ->select('id', 'name', 'salary')
                ->addSelect([
                    'program_name' => Program::select('name')
                        ->whereColumn('programs.id', 'performances.program_id')
                        ->limit(1),
                    'total_final_score' => Performance::selectRaw('SUM(final_score)')
                        ->whereColumn('performances.user_id', 'users.id')
                ])
                ->groupBy('id', 'name', 'salary', 'program_name')
                ->havingRaw('SUM(final_score) > 100')
                ->get();

            $employees->transform(function ($employee) {
                $excess_percentage = $employee->total_final_score - 100;
                $employee->bonus = $employee->salary * ($excess_percentage / 100);
                return $employee;
            });

            return view('dashboard', compact('programs', 'employees'));
        }

        return view('dashboard');
    }
}
