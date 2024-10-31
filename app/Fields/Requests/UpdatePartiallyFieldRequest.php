<?php

declare(strict_types=1);

namespace App\Fields\Requests;

use App\Shared\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdatePartiallyFieldRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'nullable|string|min:1',
            'linkedItemId' => 'nullable|exists:linked_items,id',
            'parameterId' => 'nullable|exists:parameters,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'value.string' => 'The value field must be a string.',
            'value.min' => 'The value field must be at least 1 characters.',
            'linkedItemId.exists' => 'No linked item found for this linkedItemId.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
