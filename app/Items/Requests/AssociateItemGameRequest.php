<?php

declare(strict_types=1);

namespace App\Items\Requests;

use App\Shared\Requests\BaseFormRequest;

final class AssociateItemGameRequest extends BaseFormRequest
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
            'gameId' => 'required|exists:games,id',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'itemId.required' => 'The itemId field is required.',
            'itemId.exists' => 'No items found for this itemId.',
            'gameId.required' => 'The gameId field is required.',
            'gameId.exists' => 'No games found for this gameId.',
        ];
    }
}
