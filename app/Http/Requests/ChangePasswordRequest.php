<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to use this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for changing password.
     */
    public function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'password.required'  => 'Password cannot be empty.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min'       => 'Password must be at least 6 characters long.',
        ];
    }
}
