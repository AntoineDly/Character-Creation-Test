<?php

declare(strict_types=1);

namespace App\Characters\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateCharacterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'gameId' => 'required|string|exists:games,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'gameId.required' => 'The gameId field is required.',
            'gameId.string' => 'The gameId field must be a string.',
            'gameId.exists' => 'No game found for this gameId.',
        ];
    }
}
