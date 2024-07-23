<?php

declare(strict_types=1);

namespace App\Character\Requests;

use App\Base\Requests\BaseFormRequest;

final class CreateCharacterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:20',
            'gameId' => 'required|exists:games,id',
            'userId' => 'required|exists:users,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.min' => 'The name feld must be at least 3 characters.',
            'name.max' => 'The name may not be greater than 20 characters.',
        ];
    }
}
