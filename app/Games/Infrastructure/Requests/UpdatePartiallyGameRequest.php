<?php

declare(strict_types=1);

namespace App\Games\Infrastructure\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdatePartiallyGameRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|min:3|max:20',
            'visibleForAll' => 'nullable|boolean',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.string' => 'The name field must be a string.',
            'name.min' => 'The name field must be at least 3 characters.',
            'name.max' => 'The name field must not be greater than 20 characters.',
            'visibleForAll.boolean' => 'The visibleForAll field must be a boolean.',
        ];
    }
}
