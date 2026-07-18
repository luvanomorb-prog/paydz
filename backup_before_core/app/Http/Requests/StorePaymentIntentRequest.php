<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentIntentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:50'],
            'currency' => ['sometimes', 'string', 'size:3'],
            'description' => ['nullable', 'string', 'max:255'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            'return_url' => ['nullable', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'المبلغ مطلوب.',
            'amount.min' => 'المبلغ يجب أن يكون 50 دج على الأقل.',
        ];
    }
}

