<?php

namespace App\Services;

use App\Models\Badge;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RewardService
{
    /**
     * Fetch a random dog image and attach it as a badge to a model.
     * 
     * @param mixed $model (Can be a Routine or Habit instance)
     * @return Badge
     */
    public function awardBadgeTo($model): Badge
    {
        // 1. Call the Dog CEO API for a random image URL
        $response = Http::get('https://dog.ceo/api/breeds/image/random');
        
        $imageUrl = $response->json('message'); // The API returns the URL in the 'message' key

        // 2. Download the actual image file contents
        $imageContents = Http::get($imageUrl)->body();

        // 3. Generate a unique filename
        $extension = pathinfo($imageUrl, PATHINFO_EXTENSION) ?: 'jpg';
        $filename = 'badges/' . Str::random(40) . '.' . $extension;

        // 4. Save the file securely to our local public storage
        Storage::disk('public')->put($filename, $imageContents);

        // 5. Create the polymorphic badge record
        // The $model->badges() relationship automatically fills in badgeable_id and badgeable_type!
        return $model->badges()->create([
            'image_path' => $filename,
        ]);
    }
}