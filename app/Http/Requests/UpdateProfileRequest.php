<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'string',
            'email' => 'email|unique:users,email,' . auth()->id(),
            'role' => 'sometimes|required|string|in:seller,user',
            'phone' => 'string',
            'city' => 'string',
            'address' => 'string',
            'store_info' => 'array',
            'store_info.store_name' => 'string',
            'store_info.store_city' => 'string',
            'store_info.store_description' => 'string',
            'store_info.bank_account_details' => 'array',
            'store_info.bank_account_details.bank_name' => 'string',
            'store_info.bank_account_details.account_name' => 'string',
            'store_info.bank_account_details.account_rib' => 'string|size:24',
        ];
    }
}
