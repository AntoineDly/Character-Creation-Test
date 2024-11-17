<?php

declare(strict_types=1);

namespace App\Items\Requests;

use App\Shared\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateItemRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'componentId' => 'required|exists:components,id',
            'categoryId' => 'required|exists:categories,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'componentId.required' => 'The componentId field is required.',
            'componentId.exists' => 'No component found for this componentId.',
            'categoryId.required' => 'The categoryId field is required.',
            'categoryId.exists' => 'No category found for this categoryId.',
        ];
    }
}
