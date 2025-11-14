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
        $productType = $this->input('product_type', 'single');

        $baseRules = [
            'product_name' => 'required',
            'sku' => 'required|unique:products,sku,' . $productId,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_type' => 'required|in:single,variant',
        ];

        if ($productType === 'single') {
            $baseRules += [
                'original_price' => 'required|numeric',
                'discounted_price' => 'nullable|numeric',
                'quantity_in_stock' => 'required|numeric',
            ];
        }

        if ($productType === 'variant') {
            $baseRules += [
                'original_price' => 'nullable',
                'discounted_price' => 'nullable',
                'quantity_in_stock' => 'nullable',
                'variants' => 'required|array|min:1',
                'variants.*.sku' => 'required|string|max:50|unique:product_variants,sku',
                'variants.*.price' => 'required|numeric|min:0',
                'variants.*.quantity_in_stock' => 'required|numeric|min:0',
                'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'variants.*.attributes' => 'nullable|array',
                'variants.*.attributes.*.name' => 'required|string',
                'variants.*.attributes.*.value' => 'required|string',
            ];
        }

        return $baseRules;
    }

    public function messages()
    {
        return [
            'product_name.required' => 'Product name is required',
            'sku.required' => 'Sku is required',
            'sku.unique' => 'Sku already exists',
            'image.image' => 'Image must be an image file',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, WEBP or GIF file',
            'image.max' => 'Image size must not exceed 2MB',
            'original_price.required' => 'Original price is required',
            'quantity_in_stock.required' => 'Quantity in stock is required',
            'category_id.required' => 'Category is required',
            'brand_id.required' => 'Brand is required',
            'variants.*.sku.required' => 'Sku for each variant is required',
            'variants.*.sku.unique' => 'Sku for each variant must be unique',
            'variants.*.price.required' => 'Price for each variant is required',
            'variants.*.quantity_in_stock' => 'Quantity in stock for each variant is required',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('image') && !$this->file('image')->isValid()) {
            $this->request->remove('image');
        }
    }
}
