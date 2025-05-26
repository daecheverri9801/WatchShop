<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'fk_category_id' => ['nullable', 'exists:categories,id'],
            'product_name' => ['required', 'string', 'max:255'],
            'product_ref' => ['required', 'string', 'max:100', 'unique:products'],
            'fk_brand_id' => ['nullable', 'exists:brands,id'],
            'genre' => ['required', 'in:Male,Female,Unisex'],
            'fk_color_id' => ['nullable', 'exists:colors,id'],
            'fk_material_id' => ['nullable', 'exists:materials,id'],
            'uv_protection' => ['nullable', 'boolean'],
            'water_resistance' => ['nullable', 'string', 'max:50'],
            'size' => ['nullable', 'integer'],
            'price' => ['required', 'numeric', 'min:0'],
            'main_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'El nombre del producto es obligatorio',
            'product_ref.unique' => 'Esta referencia de producto ya existe',
            'main_image.required' => 'La imagen principal es obligatoria',
            'price.min' => 'El precio no puede ser negativo',
            'main_image.max' => 'La imagen no debe pesar más de 2MB',
        ];
    }
}
