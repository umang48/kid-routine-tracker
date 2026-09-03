<?php

namespace Database\Seeders;

use App\Models\Habit;
use App\Models\Routine;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Add this line

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        // 1. Create a Test User
        $user = User::factory()->create([
            'name' => 'Test Parent',
            'email' => 'test@example.com',
            // Default password for Breeze is usually 'password', but we can be explicit
            'password' => Hash::make('password'), 
        ]);

        // 2. Create a "Morning Routine" for this user
        $morningRoutine = Routine::create([
            'user_id' => $user->id,
            'name' => 'Morning Routine',
        ]);

        // 3. Create a "Bedtime Routine"
        $bedtimeRoutine = Routine::create([
            'user_id' => $user->id,
            'name' => 'Bedtime Routine',
        ]);

        // 4. Add some default habits to the Morning Routine
        $morningHabits = [
            'Wake up with a smile',
            'Brush teeth',
            'Eat a healthy breakfast',
        ];

        foreach ($morningHabits as $habitName) {
            Habit::create([
                'user_id' => $user->id,
                'routine_id' => $morningRoutine->id,
                'name' => $habitName,
            ]);
        }
        
        // 5. Add habits to the Bedtime Routine
        $bedtimeHabits = [
            'Put toys away',
            'Read a story',
            'Brush teeth',
        ];

        foreach ($bedtimeHabits as $habitName) {
            Habit::create([
                'user_id' => $user->id,
                'routine_id' => $bedtimeRoutine->id,
                'name' => $habitName,
            ]);
        }
    }
}
