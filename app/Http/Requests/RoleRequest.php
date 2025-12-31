<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name,',
            'permission' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter the role name.',
            'name.unique' => 'This role name is already in use.',
            'permission.required' => 'Please select at least one permission.',
            'permission.array' => 'Invalid permissions format.',
            'permission.min' => 'Please select at least one permission.',
        ];
    }
}
