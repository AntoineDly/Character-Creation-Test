<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Requests;

use App\Shared\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateDefaultComponentFieldRequest extends BaseFormRequest
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
            'componentId' => 'required|exists:components,id',
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
            'componentId.required' => 'The componentId field is required.',
            'componentId.exists' => 'No component found for this componentId.',
            'parameterId.required' => 'The componentId field is required.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
