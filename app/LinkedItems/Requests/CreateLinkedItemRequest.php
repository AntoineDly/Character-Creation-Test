<?php

declare(strict_types=1);

namespace App\LinkedItems\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateLinkedItemRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'playableItemId' => 'required|exists:playable_items,id',
            'characterId' => 'required|exists:characters,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'playableItemId.required' => 'The playableItemId field is required.',
            'playableItemId.exists' => 'No item found for this playableItemId.',
            'characterId.required' => 'The characterId field is required.',
            'characterId.exists' => 'No character found for this characterId.',
        ];
    }
}
