<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'sort_by' => ['sometimes', 'string', Rule::in(['title', 'created_at', 'updated_at'])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],

            // Tambahkan 'nullable' agar field boleh kosong
            'gender' => ['sometimes', 'nullable', 'string', Rule::in(['male', 'female'])],
            'age_min' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'age_max' => ['sometimes', 'nullable', 'integer', 'min:0', 'gte:age_min'],

            // Aturan untuk checkbox sudah benar dengan 'present' dan 'boolean'
            'is_vaccinated' => ['sometimes', 'present', 'boolean'],
            'is_dewormed' => ['sometimes', 'present', 'boolean'],
        ];
    }
}
