<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $productId,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_type' => 'required|in:single,variant',
            'description' => 'nullable|string',
        ];

        if ($productType === 'single') {
            $baseRules += [
                'original_price' => 'required|numeric|min:0',
                'discounted_price' => 'nullable|numeric|min:0',
                'quantity_in_stock' => 'required|integer|min:0',
            ];
        }

        if ($productType === 'variant') {
            $baseRules += [
                'original_price' => 'nullable',
                'discounted_price' => 'nullable',
                'quantity_in_stock' => 'nullable',
                'variants' => 'required|array|min:1',
                'variants.*.sku' => 'required|string|max:50',
                'variants.*.price' => 'required|numeric|min:0',
                'variants.*.quantity_in_stock' => 'required|integer|min:0',
                'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'variants.*.attributes' => 'nullable|array',
                'variants.*.attributes.*.name' => 'required|string',
                'variants.*.attributes.*.value' => 'required|string',
            ];

            if ($this->has('variants')) {
                foreach ($this->input('variants') as $index => $variant) {
                    if (isset($variant['id']) && !empty($variant['id'])) {
                        $baseRules['variants.' . $index . '.sku'] = 'required|string|max:50|unique:product_variants,sku,' . $variant['id'];
                    } else {
                        $baseRules['variants.' . $index . '.sku'] = 'required|string|max:50|unique:product_variants,sku';
                    }
                }
            }
        }

        return $baseRules;
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'Product name is required.',
            'sku.required' => 'SKU is required.',
            'sku.unique' => 'SKU already exists.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Image size must not exceed 2MB.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'product_type.required' => 'Product type is required.',
            'product_type.in' => 'Product type must be either single or variant.',
            'original_price.required' => 'Original price is required for single products.',
            'original_price.numeric' => 'Original price must be a number.',
            'original_price.min' => 'Original price must be at least 0.',
            'discounted_price.numeric' => 'Discounted price must be a number.',
            'discounted_price.min' => 'Discounted price must be at least 0.',
            'quantity_in_stock.required' => 'Quantity in stock is required for single products.',
            'quantity_in_stock.integer' => 'Quantity in stock must be a whole number.',
            'quantity_in_stock.min' => 'Quantity in stock must be at least 0.',
            'variants.required' => 'At least one variant is required for variant products.',
            'variants.array' => 'Variants must be an array.',
            'variants.min' => 'At least one variant is required.',
            'variants.*.sku.required' => 'Variant SKU is required.',
            'variants.*.sku.unique' => 'This variant SKU already exists.',
            'variants.*.price.required' => 'Variant price is required.',
            'variants.*.price.numeric' => 'Variant price must be a number.',
            'variants.*.price.min' => 'Variant price must be at least 0.',
            'variants.*.quantity_in_stock.required' => 'Variant quantity in stock is required.',
            'variants.*.quantity_in_stock.integer' => 'Variant quantity in stock must be a whole number.',
            'variants.*.quantity_in_stock.min' => 'Variant quantity in stock must be at least 0.',
            'variants.*.image.image' => 'Variant image must be an image file.',
            'variants.*.image.mimes' => 'Variant image must be a file of type: jpeg, png, jpg, gif, webp.',
            'variants.*.image.max' => 'Variant image size must not exceed 2MB.',
            'variants.*.attributes.array' => 'Variant attributes must be an array.',
            'variants.*.attributes.*.name.required' => 'Attribute name is required.',
            'variants.*.attributes.*.value.required' => 'Attribute value is required.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('image') && !$this->file('image')->isValid()) {
            $this->request->remove('image');
        }
    }
}
