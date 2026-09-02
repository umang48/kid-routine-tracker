<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Habit extends Model
{
    protected $fillable = ['name', 'routine_id'];

    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class);
    }

    public function badges(): MorphMany
    {
        return $this->morphMany(Badge::class, 'badgeable');
    }
}