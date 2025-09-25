<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayedQuiz extends Model
{
    protected $fillable = [
        'player_id',
        'quiz_id',
        'expo_id',
        'started_on',
        'ended_on',
        'points',
        'quiz_max_points',
        'quiz_name',
        'expo_name',
    ];

    protected $casts = [
        'started_on' => 'datetime',
        'ended_on' => 'datetime',
        'points' => 'integer',
        'quiz_max_points' => 'integer',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function expo(): BelongsTo
    {
        return $this->belongsTo(Expo::class);
    }
}
