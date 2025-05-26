<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'category_name' => ['string', 'required', 'max:100'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }


    public function messages(): array
    {
        return [
            'category_name.required' => 'El nombre de la categoría es obligatorio.',
            'main_image.max' => 'La imagen no debe superar los 2MB.',
            'main_image.mimes' => 'Solo se aceptan formatos: JPEG, PNG, JPG, GIF o WEBP.',
        ];
    }
}
