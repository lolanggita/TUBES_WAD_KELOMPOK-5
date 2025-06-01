<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        // Hanya user yang punya middleware 'role:administrator' yang sudah dicek di Controller/Route
        // Jadi di sini kita return true.
        return true;
    }

    public function rules()
    {
        return [
            'title'          => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'start_time'     => ['required', 'date', 'after:now'],
            'end_time'       => ['nullable', 'date', 'after:start_time'],
            'is_registrable' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        // Jika checkbox is_registrable tidak ter‐check, kirimkan nilai false
        if (! $this->has('is_registrable')) {
            $this->merge(['is_registrable' => false]);
        }
    }
}
