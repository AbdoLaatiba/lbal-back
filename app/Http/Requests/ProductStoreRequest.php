<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'brand' => 'required|string',
            'condition' => 'required|in:new,like new,gently used,used,vintage,fair,poor',
            'status' => 'in:draft,published,sold,inactive,archived',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'required|array',
            'images.*' => 'required|exists:media,id',
        ];
    }
}
