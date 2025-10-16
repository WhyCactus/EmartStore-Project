<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $productId = $this->route('id');

        return [
            'product_name' => 'required',
            'product_code' => "required|string|max:50|unique:products,product_code,{$productId}",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'original_price' => 'required',
            'discounted_price' => 'nullable',
            'quantity_in_stock' => 'required',
            'description' => 'nullable',
            'category_id' => 'required',
            'brand_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'Product name is required',
            'product_code.required' => 'Product code is required',
            'product_code.unique' => 'Product code already exists',
            'image.image' => 'Image must be an image file',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, WEBP or GIF file',
            'image.max' => 'Image size must not exceed 2MB',
            'original_price.required' => 'Original price is required',
            'quantity_in_stock.required' => 'Quantity in stock is required',
            'category_id.required' => 'Category is required',
            'brand_id.required' => 'Brand is required',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('image') && !$this->file('image')->isValid()) {
            $this->request->remove('image');
        }
    }
}
