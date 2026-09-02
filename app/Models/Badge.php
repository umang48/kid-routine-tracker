<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Badge extends Model
{
    protected $fillable = ['image_path'];

    public function badgeable(): MorphTo
    {
        return $this->morphTo();
    }
}