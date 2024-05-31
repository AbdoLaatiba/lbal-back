<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'price' => 'numeric',
            'category' => 'string',
            'brand' => 'string',
            'condition' => 'in:new,like new,gently used,used,vintage,fair,poor',
            'status' => 'in:draft,published,pending,sold,reserved,inactive,rejected,archived',
            'color' => 'string',
            'size' => 'string',
            'description' => 'string',
            'images' => 'array',
            'images.*' => 'exists:media,id',
        ];
    }
}
