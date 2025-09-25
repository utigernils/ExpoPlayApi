<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsoleRequest extends FormRequest
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
            'api_token' => 'sometimes|string|unique:consoles,api_token,' . $this->route('Console')->id,
            'current_expo_id' => 'sometimes|nullable|integer|exists:expos,id',
            'current_quiz_id' => 'sometimes|nullable|integer|exists:quizzes,id',
            'name' => 'sometimes|string|max:100',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
