<?php

declare(strict_types=1);

namespace App\Shared\SortAndPagination\Requests;

use App\Shared\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class SortedAndPaginatedRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|string>
     */
    public function rules(): array
    {
        $this->mergeIfMissing(['sortOrder' => 'asc']);
        $this->mergeIfMissing(['perPage' => 15]);
        $this->mergeIfMissing(['page' => 1]);

        return [
            'sortOrder' => 'required|in:asc,desc',
            'perPage' => 'required|int|max:100',
            'page' => 'required|int',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'sortOrder.required' => 'The sortOrder field is required.',
            'sortOrder.in' => 'The sortOrder field must be either "asc" or "desc".',
            'perPage.required' => 'The perPage field is required.',
            'perPage.int' => 'The perPage field must be an int.',
            'perPage.max' => 'The perPage field must not be greater than 100.',
            'page.required' => 'The page field is required.',
            'page.int' => 'The page field must be an int.',
        ];
    }
}
