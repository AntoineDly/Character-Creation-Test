<?php

declare(strict_types=1);

namespace App\ComponentFields\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdateComponentFieldRequest extends BaseRequest
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
            'componentId' => 'required|exists:components,id',
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
            'componentId.required' => 'The componentId field is required.',
            'componentId.exists' => 'No component found for this componentId.',
            'parameterId.required' => 'The parameterId field is required.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
