<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token' => 'required',
            'email' => 'required|email',
            'password'=> 'required|confirmed|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required'=> 'Please enter your password.',
            'password.confirmed'=> 'This password does not match.',
            'password.min'=> 'Password must be at least 8 characters.',
        ];
    }
}
