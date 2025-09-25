<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expo extends Model
{
    protected $fillable = [
        'name',
        'introduction_title',
        'introduction_subtitle',
        'location',
        'starts_on',
        'ends_on',
    ];

    protected $casts = [
        'starts_on' => 'date',
        'ends_on' => 'date',
    ];

    public function consoles(): HasMany
    {
        return $this->hasMany(Console::class, 'current_expo_id');
    }

    public function playedQuizzes(): HasMany
    {
        return $this->hasMany(PlayedQuiz::class);
    }
}
