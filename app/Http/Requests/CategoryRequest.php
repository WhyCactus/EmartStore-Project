<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            'category_name' => 'required|string|max:255'. $categoryId,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'category_name.required' => 'Please enter a category name.',
            'category_name.max' => 'Category name must not exceed 255 characters.',
            'image.max' => 'Image size must not exceed 2MB.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->hasFile('image') && !$this->file('image')->isValid()) {
            $this->request->remove('image');
        }
    }
}
