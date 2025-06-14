<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UKMProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization logic can be added here, for now allow all authenticated users
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact' => 'required|string|max:255',
        ];
    }
}
