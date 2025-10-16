<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'quiz_id' => 'required|integer|exists:quizzes,id',
            'question' => 'required|string|max:150',
            'question_type' => 'required|integer|between:0,255',
            'answer_possibilities' => 'required|json',
            'points' => 'required|integer|between:0,127',
            'is_hidden' => 'boolean',
        ];
    }
}
