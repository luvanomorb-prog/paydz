<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

            'amount' => ['required', 'numeric', 'min:1'],

            'currency' => ['required', 'string', 'size:3'],

            'success_url' => ['nullable', 'url'],

            'cancel_url' => ['nullable', 'url'],

            'expires_at' => ['nullable', 'date', 'after:now'],

            'max_payments' => ['nullable', 'integer', 'min:1'],

            'metadata' => ['nullable', 'array'],
        ];
    }
}
