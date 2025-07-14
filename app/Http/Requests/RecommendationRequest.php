<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RecommendationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'weights' => ['required', 'array'],
            'weights.*' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                // * Cek jika validasi dasar sudah gagal, tidak perlu lanjut.
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                // * Ambil data 'weights' yang sudah divalidasi
                $weights = $this->validated('weights');

                // * Lakukan validasi kustom untuk total bobot
                if (array_sum($weights) != 100) {
                    // * Jika gagal, tambahkan pesan error
                    $validator->errors()->add(
                        'total',
                        'Total must be 100'
                    );
                }
            }
        ];
    }
}
