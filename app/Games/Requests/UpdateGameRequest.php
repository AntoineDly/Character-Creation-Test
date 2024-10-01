<?php

declare(strict_types=1);

namespace App\Games\Requests;

use App\Shared\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdateGameRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string|exists:games,id',
            'name' => 'required|string|min:3|max:20',
            'visibleForAll' => 'required|boolean',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'id.required' => 'The id field is required.',
            'id.string' => 'The id field must be a string.',
            'id.exists' => 'No game found for this id.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.min' => 'The name field must be at least 3 characters.',
            'name.max' => 'The name field must not be greater than 20 characters.',
            'visibleForAll.required' => 'The visibleForAll field is required.',
            'visibleForAll.boolean' => 'The visibleForAll field must be a boolean.',
        ];
    }
}
