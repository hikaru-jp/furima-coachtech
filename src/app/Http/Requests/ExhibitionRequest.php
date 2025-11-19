<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],

            'description' => ['required', 'max:255'],

            'item_image' => ['nullable', 'image', 'mimes:jpeg,png'],

            'categories' => ['required', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],

            'condition' => ['required'],

            'price' => ['required', 'integer', 'min:0'],

            'brand' => ['nullable'],
        ];
    }
}
