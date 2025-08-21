<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateLinkedItemFieldRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|string|min:1',
            'linkedItemId' => 'required|exists:linked_items,id',
            'parameterId' => 'required|exists:parameters,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'value.required' => 'The value field is required.',
            'value.string' => 'The value field must be a string.',
            'value.min' => 'The value field must be at least 1 characters.',
            'linkedItemId.required' => 'The linkedItemId field is required.',
            'linkedItemId.exists' => 'No linked item found for this linkedItemId.',
            'parameterId.required' => 'The componentId field is required.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
