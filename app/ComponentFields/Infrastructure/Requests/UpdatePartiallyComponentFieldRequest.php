<?php

declare(strict_types=1);

namespace App\ComponentFields\Infrastructure\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdatePartiallyComponentFieldRequest extends BaseRequest
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
            'componentId' => 'nullable|exists:components,id',
            'parameterId' => 'nullable|exists:parameters,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'value.required' => 'The value field is required.',
            'value.string' => 'The value field must be a string.',
            'value.min' => 'The value field must be at least 1 characters.',
            'componentId.exists' => 'No component found for this componentId.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
