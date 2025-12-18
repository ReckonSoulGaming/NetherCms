<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentmethodRequest extends FormRequest
{
    /**
     * Allow access (modify if admin-only).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for creating or updating a payment option.
     */
    public function rules(): array
    {
        return [
            'provider'      => 'required|string|max:100',
            'title'         => 'required|string|max:255',
            'price'         => 'required|numeric|min:0.01',
            'points_amount' => 'required|numeric|min:1',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'provider.required'      => 'Please enter a provider name.',
            'title.required'         => 'Please enter a option title.',

            'price.required'         => 'Please enter the price.',
            'price.numeric'          => 'Price must be a number.',
            'price.min'              => 'Price must be at least 0.01.',

            'points_amount.required' => 'Please enter the amount of points.',
            'points_amount.numeric'  => 'Points amount must be a number.',
            'points_amount.min'      => 'Points amount must be at least 1.',
        ];
    }
}
