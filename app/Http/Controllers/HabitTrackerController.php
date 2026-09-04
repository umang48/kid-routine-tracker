<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Routine;
use App\Services\RewardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HabitTrackerController extends Controller
{
    // Display the main dashboard with all routines, habits, and badges
    public function index(Request $request)
    {
        // Eager load relationships to prevent N+1 queries
        $routines = $request->user()->routines()->with(['habits.badges', 'badges'])->get();

        // Pass the data to a React component named 'HabitTracker/Index'
        return Inertia::render('HabitTracker/Index', [
            'routines' => $routines
        ]);
    }

    // Store a newly created habit
    public function storeHabit(Request $request, Routine $routine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $routine->habits()->create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
        ]);

        // Inertia automatically handles the redirect and updates the React state without a full page reload
        return redirect()->back();
    }

    // Mark a habit complete and fetch the animal reward
    public function completeHabit(Habit $habit, RewardService $rewardService)
    {
        // Ensure the user owns this habit before rewarding
        if ($habit->user_id !== auth()->id()) {
            abort(403);
        }

        // Trigger the service we built in Step 3
        $rewardService->awardBadgeTo($habit);

        return redirect()->back();
    }

    // Delete a specific habit
    public function destroyHabit(Habit $habit)
    {
        if ($habit->user_id !== auth()->id()) {
            abort(403);
        }

        $habit->delete();

        return redirect()->back();
    }

    // Delete an entire routine (cascades to delete all its habits)
    public function destroyRoutine(Routine $routine)
    {
        if ($routine->user_id !== auth()->id()) {
            abort(403);
        }

        $routine->delete();

        return redirect()->back();
    }

    // Store a newly created routine
    public function storeRoutine(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->routines()->create([
            'name' => $request->name,
        ]);

        return redirect()->back();
    }
}