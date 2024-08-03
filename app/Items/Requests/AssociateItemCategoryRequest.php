<?php

declare(strict_types=1);

namespace App\Items\Requests;

use App\Shared\Requests\BaseFormRequest;

final class AssociateItemCategoryRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'itemId' => 'required|exists:items,id',
            'categoryId' => 'required|exists:categories,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'itemId.required' => 'The itemId field is required.',
            'itemId.exists' => 'No items found for this itemId.',
            'categoryId.required' => 'The categoryId field is required.',
            'categoryId.exists' => 'No categories found for this categoryId.',
        ];
    }
}
