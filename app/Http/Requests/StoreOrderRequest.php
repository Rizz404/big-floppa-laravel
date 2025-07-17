<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart_item_ids' => ['required', 'array', 'min:1'],
            'cart_item_ids.*' => ['ulid', 'exists:cart_items,id'],
            'address_id' => ['required', 'ulid', 'exists:user_addresses,id'],
        ];
    }
}
