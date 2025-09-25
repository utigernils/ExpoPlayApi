<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Console extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_expo_id',
        'current_quiz_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function currentExpo(): BelongsTo
    {
        return $this->belongsTo(Expo::class, 'current_expo_id');
    }

    public function currentQuiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'current_quiz_id');
    }
}
