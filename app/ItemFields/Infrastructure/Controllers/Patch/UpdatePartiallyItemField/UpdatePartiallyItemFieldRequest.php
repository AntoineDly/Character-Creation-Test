<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Controllers\Patch\UpdatePartiallyItemField;

use App\Shared\Infrastructure\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdatePartiallyItemFieldRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'nullable|string|min:1',
            'itemId' => 'nullable|exists:items,id',
            'parameterId' => 'nullable|exists:parameters,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'value.string' => 'The value field must be a string.',
            'value.min' => 'The value field must be at least 1 characters.',
            'itemId.exists' => 'No item found for this itemId.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
