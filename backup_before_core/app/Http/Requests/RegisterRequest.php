<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],

            'business_name' => ['required', 'string', 'max:255'],
            'business_email' => ['required', 'email', 'unique:merchants,business_email'],
            'business_phone' => ['nullable', 'string', 'max:30'],
        ];
    }
}
