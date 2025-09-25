<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'wants_newsletter',
    ];

    protected $casts = [
        'wants_newsletter' => 'boolean',
    ];

    public function playedQuizzes(): HasMany
    {
        return $this->hasMany(PlayedQuiz::class);
    }
}
