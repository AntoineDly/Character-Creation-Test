<?php

declare(strict_types=1);

namespace App\CategoryGames\Infrastructure\Requests;

use App\Shared\Infrastructure\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateCategoryGameRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'categoryId' => 'required|exists:categories,id',
            'gameId' => 'required|exists:games,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'categoryId.required' => 'The categoryId field is required.',
            'categoryId.exists' => 'No category found for this categoryId.',
            'gameId.required' => 'The gameId field is required.',
            'gameId.exists' => 'No game found for this gameId.',
        ];
    }
}
