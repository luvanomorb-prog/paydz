<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1'],

            'currency' => ['nullable', 'string'],

            'customer_email' => ['required', 'email'],

            'customer_name' => ['nullable', 'string'],

            'description' => ['nullable', 'string'],

            'metadata' => ['nullable', 'array'],
        ];
    }
}
