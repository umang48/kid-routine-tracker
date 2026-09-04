<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HabitTrackerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Our Habit Tracker Routes
    Route::get('/tracker', [HabitTrackerController::class, 'index'])->name('tracker.index');
    Route::post('/routines/{routine}/habits', [HabitTrackerController::class, 'storeHabit'])->name('habits.store');
    Route::post('/habits/{habit}/complete', [HabitTrackerController::class, 'completeHabit'])->name('habits.complete');
    
    // Add these two new DELETE routes
    Route::delete('/habits/{habit}', [HabitTrackerController::class, 'destroyHabit'])->name('habits.destroy');
    Route::delete('/routines/{routine}', [HabitTrackerController::class, 'destroyRoutine'])->name('routines.destroy');
   
    });

require __DIR__.'/auth.php';
