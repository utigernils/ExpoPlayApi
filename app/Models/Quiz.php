<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function consoles(): HasMany
    {
        return $this->hasMany(Console::class, 'current_quiz_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function playedQuizzes(): HasMany
    {
        return $this->hasMany(PlayedQuiz::class);
    }
}
