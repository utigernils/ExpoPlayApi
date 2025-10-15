<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EndQuizRequest extends FormRequest
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
            "played_quiz_id" => "required|exists:played_quizzes,id",
            "points" => "required|integer|min:0"
        ];
    }
}
