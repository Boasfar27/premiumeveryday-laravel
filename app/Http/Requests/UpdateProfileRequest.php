<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama lengkap maksimal 255 karakter',
            'phone.max' => 'Nomor WhatsApp maksimal 20 karakter',
            'phone.regex' => 'Format nomor WhatsApp tidak valid',
        ];
    }
} 