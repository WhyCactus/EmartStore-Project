<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Please enter :attribute.',
            'min' => ':attribute requires at least :min characters.',
            'same' => ':attribute does not match.',
        ];
    }

    public function attributes()
    {
        return [
            'currentPassword' => 'current password',
            'newPassword' => 'new password',
            'confirmPassword' => 'confirm password',
        ];
    }
}
