<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpoRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'introduction_title' => 'nullable|string|max:255',
            'introduction_subtitle' => 'nullable|string',
            'location' => 'required|string|max:150',
            'starts_on' => 'required|date|date_format:Y-m-d',
            'ends_on' => 'required|date|date_format:Y-m-d|after_or_equal:starts_on',
        ];
    }
}
