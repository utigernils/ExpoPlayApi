<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsoleRequest extends FormRequest
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
            'api_token' => 'required|string|unique:consoles,api_token',
            'current_expo_id' => 'nullable|integer|exists:expos,id',
            'current_quiz_id' => 'nullable|integer|exists:quizzes,id',
            'name' => 'required|string|max:100',
            'is_active' => 'boolean',
        ];
    }
}
