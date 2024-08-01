<?php

declare(strict_types=1);

namespace App\Items\Requests;

use App\Base\Requests\BaseFormRequest;

final class AssociateItemCharacterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
            'itemId.exists' => 'No items found for this itemId.',
            'characterId.required' => 'The characterId field is required.',
            'characterId.exists' => 'No characters found for this characterId.',
        ];
    }
}
