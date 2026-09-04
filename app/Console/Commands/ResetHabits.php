<?php

namespace App\Console\Commands;

use App\Models\Badge;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResetHabits extends Command
{
    // The terminal command we will use to run this manually
    protected $signature = 'habits:reset';

    // A description of what the command does
    protected $description = 'Resets all daily habits by deleting badges and their image files';

    public function handle()
    {
        $badges = Badge::all();
        $count = $badges->count();

        foreach ($badges as $badge) {
            // 1. Delete the image file from our public storage
            if (Storage::disk('public')->exists($badge->image_path)) {
                Storage::disk('public')->delete($badge->image_path);
            }
            
            // 2. Delete the database record
            $badge->delete();
        }

        // Output a success message to the terminal
        $this->info("Successfully reset {$count} habits and cleared images!");
    }
}
