<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'question_type',
        'answer_possibilities',
        'points',
        'is_hidden',
    ];

    protected $casts = [
        'answer_possibilities' => 'array',
        'question_type' => 'integer',
        'points' => 'integer',
        'is_hidden' => 'boolean',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
