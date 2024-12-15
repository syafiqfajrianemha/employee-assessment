<?php

use App\Http\Controllers\AssignController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Middleware\RoleCheck;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard', 301);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [RegisteredUserController::class, 'index'])->middleware(RoleCheck::class.':admin,manager')->name('user.index');
    Route::get('/users', [RegisteredUserController::class, 'getUsers'])->middleware(RoleCheck::class.':admin,manager')->name('users.get');
    Route::get('/user/{id}', [RegisteredUserController::class, 'edit'])->middleware(RoleCheck::class.':admin,manager')->name('user.edit');
    Route::patch('/user/{id}', [RegisteredUserController::class, 'update'])->middleware(RoleCheck::class.':admin,manager')->name('user.update');
    Route::delete('/user/{id}', [RegisteredUserController::class, 'destroy'])->middleware(RoleCheck::class.':admin,manager')->name('user.destroy');

    Route::get('/program', [ProgramController::class, 'index'])->middleware(RoleCheck::class.':admin,program,manager')->name('program.index');
    Route::get('/program/create', [ProgramController::class, 'create'])->middleware(RoleCheck::class.':admin,program')->name('program.create');
    Route::get('/program/{id}', [ProgramController::class, 'edit'])->middleware(RoleCheck::class.':admin,program')->name('program.edit');
    Route::post('/program', [ProgramController::class, 'store'])->middleware(RoleCheck::class.':admin,program')->name('program.store');
    Route::patch('/program/{id}', [ProgramController::class, 'update'])->middleware(RoleCheck::class.':admin,program')->name('program.update');
    Route::delete('/program/{id}', [ProgramController::class, 'destroy'])->middleware(RoleCheck::class.':admin,program')->name('program.destroy');
    Route::post('/program/{id}', [ProgramController::class, 'updateStatus'])->middleware(RoleCheck::class.':admin,manager')->name('program.update.status');

    Route::get('/indicator', [IndicatorController::class, 'index'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.index');
    Route::get('/indicator/filter', [IndicatorController::class, 'filter'])->name('indicator.filter');
    Route::get('/indicator/create', [IndicatorController::class, 'create'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.create');
    Route::get('/indicator/{id}', [IndicatorController::class, 'edit'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.edit');
    Route::post('/indicator', [IndicatorController::class, 'store'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.store');
    Route::patch('/indicator/{id}', [IndicatorController::class, 'update'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.update');
    Route::delete('/indicator/{id}', [IndicatorController::class, 'destroy'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.destroy');

    Route::get('/assign', [AssignController::class, 'index'])->middleware(RoleCheck::class.':admin,manager')->name('assign.index');
    Route::get('/assign/{id}', [AssignController::class, 'edit'])->middleware(RoleCheck::class.':admin,manager')->name('assign.edit');
    Route::post('/assign', [AssignController::class, 'store'])->middleware(RoleCheck::class.':admin,manager')->name('assign.store');
    Route::patch('/assign/{id}', [AssignController::class, 'update'])->middleware(RoleCheck::class.':admin,manager')->name('assign.update');
    Route::delete('/assign/{id}', [AssignController::class, 'destroy'])->middleware(RoleCheck::class.':admin,manager')->name('assign.destroy');

    Route::get('/calculate', [PerformanceController::class, 'index'])->middleware(RoleCheck::class.':admin,manager')->name('calculate.index');
    Route::post('/calculate', [PerformanceController::class, 'save'])->middleware(RoleCheck::class.':admin,manager')->name('calculate.save');
    Route::get('/calculate/create/{userId}/{programId}', [PerformanceController::class, 'create'])->middleware(RoleCheck::class.':admin,manager')->name('calculate.create');

    Route::get('/bonus', [BonusController::class, 'showBonusQualifiedEmployees'])->middleware(RoleCheck::class.':admin,manager')->name('bonus.index');
});

require __DIR__.'/auth.php';
