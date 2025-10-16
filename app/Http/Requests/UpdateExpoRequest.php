<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpoRequest extends FormRequest
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
            'name' => 'sometimes|string|max:100',
            'introduction_title' => 'sometimes|string|max:255',
            'introduction_subtitle' => 'sometimes|nullable|string',
            'location' => 'sometimes|string|max:150',
            'starts_on' => 'sometimes|date|date_format:Y-m-d',
            'ends_on' => 'sometimes|date|date_format:Y-m-d|after_or_equal:starts_on',
        ];
    }
}
