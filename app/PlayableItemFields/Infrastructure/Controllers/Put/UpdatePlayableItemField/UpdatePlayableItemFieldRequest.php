<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Controllers\Put\UpdatePlayableItemField;

use App\Shared\Infrastructure\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdatePlayableItemFieldRequest extends BaseRequest
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
            'playableItemId' => 'required|exists:playableItems,id',
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
            'playableItemId.required' => 'The playableItemId field is required.',
            'playableItemId.exists' => 'No playableItem found for this playableItemId.',
            'parameterId.required' => 'The parameterId field is required.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
