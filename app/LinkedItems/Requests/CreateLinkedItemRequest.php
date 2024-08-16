<?php

declare(strict_types=1);

namespace App\LinkedItems\Requests;

use App\Shared\Requests\BaseFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateLinkedItemRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'itemId' => 'required|exists:items,id',
            'characterId' => 'required|exists:characters,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'itemId.required' => 'The itemId field is required.',
            'itemId.exists' => 'No item found for this itemId.',
            'characterId.required' => 'The characterId field is required.',
            'characterId.exists' => 'No character found for this characterId.',
        ];
    }
}
