<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Routine extends Model
{
    protected $fillable = ['name'];

    public function habits(): HasMany
    {
        return $this->hasMany(Habit::class);
    }

    public function badges(): MorphMany
    {
        return $this->morphMany(Badge::class, 'badgeable');
    }
}