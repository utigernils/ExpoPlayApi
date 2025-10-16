<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'wants_newsletter',
        'join_link',
    ];

    protected $casts = [
        'wants_newsletter' => 'boolean',
    ];

    public function playedQuizzes(): HasMany
    {
        return $this->hasMany(PlayedQuiz::class);
    }
}
