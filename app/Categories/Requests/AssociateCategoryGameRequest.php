<?php

declare(strict_types=1);

namespace App\Categories\Requests;

use App\Shared\Requests\BaseFormRequest;

final class AssociateCategoryGameRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
            'categoryId.exists' => 'No categories found for this categoryId.',
            'gameId.required' => 'The gameId field is required.',
            'gameId.exists' => 'No games found for this gameId.',
        ];
    }
}
