<?php

declare(strict_types=1);

namespace App\Parameters\Infrastructure\Controllers\Post\CreateParameter;

use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Shared\Infrastructure\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class CreateParameterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|Enum[]|string[]|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:20',
            'type' => ['required', Rule::enum(TypeParameterEnum::class)],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.min' => 'The name field must be at least 3 characters.',
            'name.max' => 'The name field must not be greater than 20 characters.',
            'type.required' => 'The type field is required.',
            'type.enum' => 'The type field must be of compatible types.',
        ];
    }
}
