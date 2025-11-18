<?php

declare(strict_types=1);

namespace App\PlayableItems\Infrastructure\Controllers\Post\CreatePlayableItem;

use App\Shared\Infrastructure\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreatePlayableItemRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
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
            'itemId.exists' => 'No item found for this itemId.',
            'gameId.required' => 'The gameId field is required.',
            'gameId.exists' => 'No game found for this gameId.',
        ];
    }
}
