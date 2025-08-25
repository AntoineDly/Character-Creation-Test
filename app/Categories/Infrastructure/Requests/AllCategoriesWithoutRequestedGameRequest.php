<?php

declare(strict_types=1);

namespace App\Categories\Infrastructure\Requests;

use App\Shared\Infrastructure\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class AllCategoriesWithoutRequestedGameRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'gameId' => 'required|exists:games,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'gameId.required' => 'The gameId field is required.',
            'gameId.exists' => 'No game found for this gameId.',
        ];
    }
}
