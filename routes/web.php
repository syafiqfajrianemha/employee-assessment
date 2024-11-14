<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleCheck;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard', 301);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/roc', function() {
    return view('roc.index');
})->middleware(['auth', 'verified', RoleCheck::class.':admin,manager,program'])->name('roc');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [RegisteredUserController::class, 'index'])->middleware(RoleCheck::class.':admin')->name('user.index');
    Route::get('/user/{id}', [RegisteredUserController::class, 'edit'])->middleware(RoleCheck::class.':admin')->name('user.edit');
    Route::patch('/user/{id}', [RegisteredUserController::class, 'update'])->middleware(RoleCheck::class.':admin')->name('user.update');
    Route::delete('/user/{id}', [RegisteredUserController::class, 'destroy'])->middleware(RoleCheck::class.':admin')->name('user.destroy');
});

require __DIR__.'/auth.php';
