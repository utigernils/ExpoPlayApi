<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayedQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'player_id' => 'nullable|integer|exists:players,id',
            'quiz_id' => 'nullable|integer|exists:quizzes,id',
            'expo_id' => 'nullable|integer|exists:expos,id',
            'started_on' => 'nullable|date',
            'ended_on' => 'nullable|date|after_or_equal:started_on',
            'points' => 'required|integer|min:0',
            'quiz_max_points' => 'required|integer|min:0',
            'quiz_name' => 'required|string|max:100',
            'expo_name' => 'required|string|max:100',
        ];
    }
}
