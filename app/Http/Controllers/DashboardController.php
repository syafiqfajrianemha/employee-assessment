<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'fundraising') {
            // Ambil program yang di-assign ke user
            $programs = $user->assignedPrograms()->with(['indicators.performances'])->get();

            foreach ($programs as $program) {
                $programKinerja = 0; // Inisialisasi kinerja program

                foreach ($program->indicators as $indicator) {
                    foreach ($indicator->performances as $performance) {
                        // Hanya tambahkan nilai jika actual diisi
                        if (!is_null($performance->actual)) {
                            $programKinerja += $performance->final_score;
                        }
                    }
                }

                // Simpan hasil kinerja ke dalam object program
                $program->hasilKinerja = $programKinerja > 0 ? $programKinerja : 0;
            }

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

            return view('dashboard', compact('programs', 'employees'));
        }

        return view('dashboard');
    }
}
