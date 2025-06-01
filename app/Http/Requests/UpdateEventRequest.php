<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        // Akses sudah dibatasi di Controller/Route memakai middleware
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
        // Jika checkbox tidak di‐centang, tetap kirim boolean false
        if (! $this->has('is_registrable')) {
            $this->merge(['is_registrable' => false]);
        }
    }
}
