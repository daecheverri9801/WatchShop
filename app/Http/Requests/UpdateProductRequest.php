<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'product_name' => ['required', 'string', 'max:255'],
            'product_ref' => ['required', 'string', 'max:100', 'unique:products,product_ref,' . $this->product->id],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'genre' => ['required', 'in:Male,Female,Unisex'],
            'color_id' => ['nullable', 'exists:colors,id'],
            'materials_id' => ['nullable', 'exists:materials,id'],
            'uv_protection' => ['nullable', 'boolean'],
            'water_resistance' => ['nullable', 'string', 'max:50'],
            'size' => ['nullable', 'integer'],
            'price' => ['required', 'numeric', 'min:0'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'La categoría es obligatoria',
            'product_ref.unique' => 'Esta referencia de producto ya existe',
            'price.min' => 'El precio no puede ser negativo',
        ];
    }
}
