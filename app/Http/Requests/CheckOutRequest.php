<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
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
            'recipient_name' => 'required|string|max:255',
            'recipient_address'=> 'required|string|max:255',
            'recipient_phone'=> 'required|string|max:20',
            'payment_method'=> 'required|in:cash',
        ];
    }

    public function messages(): array
    {
        return [
            'recipient_name.required' => 'Please enter a recipient name.',
            'recipient_address.required'=> 'Please enter a recipient address.',
            'recipient_phone.required'=> 'Please enter a recipient phone number.',
            'payment_method.required'=> 'Please select a payment method.'
        ];
    }
}
