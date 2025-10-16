<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
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
            'NameProduct' => 'required|string|max:255',
            'Note' => 'nullable|string',
            'CategoryId' => 'required|exists:categorys,IdCategory',
            'Status' => 'required|in:Available,Stopped',
            'MainImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sizes.*.Size' => 'required|in:S,M,L',
            'sizes.*.Price' => 'required|numeric|min:0',
            'additation_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
