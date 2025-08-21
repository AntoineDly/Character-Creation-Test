<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdatePartiallyPlayableItemFieldRequest extends BaseRequest
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
            'playableItemId' => 'nullable|exists:playableItems,id',
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
            'playableItemId.exists' => 'No playableItem found for this playableItemId.',
            'parameterId.exists' => 'No parameter found for this parameterId.',
        ];
    }
}
