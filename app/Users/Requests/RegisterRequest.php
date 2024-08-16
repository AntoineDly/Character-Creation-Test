<?php

declare(strict_types=1);

namespace App\Users\Requests;

use App\Shared\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class RegisterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.min' => 'The name feld must be at least 3 characters.',
            'name.max' => 'The name must not be greater than 20 characters.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email field must be a string.',
            'email.email' => 'The email field must be an email.',
            'email.max' => 'The email must not be greater than 50 characters.',
            'email.unique:users' => 'The email is already used for another user',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field must be a string.',
            'password.min' => 'The password feld must be at least 6 characters.',
            'password.confirmed' => 'The password must be confirmed.',
            'password_confirmation.required' => 'The password confirmation field is required.',
            'password_confirmation.string' => 'The password confirmation field must be a string.',
            'password_confirmation.min' => 'The password confirmation feld must be at least 6 characters.',
        ];
    }
}
