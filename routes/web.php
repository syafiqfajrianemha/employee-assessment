<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Middleware\RoleCheck;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [RegisteredUserController::class, 'index'])->middleware(RoleCheck::class.':admin')->name('user.index');
    Route::get('/user/{id}', [RegisteredUserController::class, 'edit'])->middleware(RoleCheck::class.':admin')->name('user.edit');
    Route::patch('/user/{id}', [RegisteredUserController::class, 'update'])->middleware(RoleCheck::class.':admin')->name('user.update');
    Route::delete('/user/{id}', [RegisteredUserController::class, 'destroy'])->middleware(RoleCheck::class.':admin')->name('user.destroy');

    Route::get('/program', [ProgramController::class, 'index'])->middleware(RoleCheck::class.':admin,program,manager')->name('program.index');
    Route::get('/program/create', [ProgramController::class, 'create'])->middleware(RoleCheck::class.':admin,program')->name('program.create');
    Route::get('/program/{id}', [ProgramController::class, 'edit'])->middleware(RoleCheck::class.':admin,program')->name('program.edit');
    Route::post('/program', [ProgramController::class, 'store'])->middleware(RoleCheck::class.':admin,program')->name('program.store');
    Route::patch('/program/{id}', [ProgramController::class, 'update'])->middleware(RoleCheck::class.':admin,program')->name('program.update');
    Route::delete('/program/{id}', [ProgramController::class, 'destroy'])->middleware(RoleCheck::class.':admin,program')->name('program.destroy');

    Route::get('/indicator', [IndicatorController::class, 'index'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.index');
    Route::get('/indicator/create', [IndicatorController::class, 'create'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.create');
    Route::get('/indicator/{id}', [IndicatorController::class, 'edit'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.edit');
    Route::post('/indicator', [IndicatorController::class, 'store'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.store');
    Route::patch('/indicator/{id}', [IndicatorController::class, 'update'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.update');
    Route::delete('/indicator/{id}', [IndicatorController::class, 'destroy'])->middleware(RoleCheck::class.':admin,manager')->name('indicator.destroy');
});

require __DIR__.'/auth.php';
