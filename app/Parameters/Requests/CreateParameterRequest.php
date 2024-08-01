<?php

declare(strict_types=1);

namespace App\Parameters\Requests;

use App\Base\Requests\BaseFormRequest;
use App\Parameters\Enums\TypeEnum;
use Illuminate\Validation\Rule;

final class CreateParameterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:20',
            'type' => ['required', Rule::enum(TypeEnum::class)],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.min' => 'The name feld must be at least 3 characters.',
            'name.max' => 'The name must not be greater than 20 characters.',
            'type.required' => 'The type field is required.',
            'type.enum' => 'The type field must be of compatible types.',
        ];
    }
}