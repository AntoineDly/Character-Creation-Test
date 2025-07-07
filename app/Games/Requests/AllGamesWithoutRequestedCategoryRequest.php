<?php

declare(strict_types=1);

namespace App\Games\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class AllGamesWithoutRequestedCategoryRequest extends BaseRequest
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
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'categoryId.required' => 'The categoryId field is required.',
            'categoryId.exists' => 'No category found for this categoryId.',
        ];
    }
}
