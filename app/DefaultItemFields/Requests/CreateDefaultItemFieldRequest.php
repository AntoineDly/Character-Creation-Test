<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Requests;

use App\Shared\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateDefaultItemFieldRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|string|min:1',
            'itemId' => 'required|exists:items,id',
            'parameterId' => 'required|exists:parameters,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'value.required' => 'The name field is required.',
            'value.string' => 'The name field must be a string.',
            'value.min' => 'The name feld must be at least 1 characters.',
            'itemId.required' => 'The itemId field is required.',
            'itemId.exists' => 'No item found for this itemId.',
            'parameterId.required' => 'The itemId field is required.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
