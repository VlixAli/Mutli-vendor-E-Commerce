<?php

namespace App\Http\Requests\Front\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'address.billing.first_name' => 'required|string|max:255',
            'address.billing.last_name' => 'required|string|max:255',
            'address.billing.email' => 'required|string|max:255',
            'address.billing.phone_number' => 'required|string|max:255',
            'address.billing.street_address' => 'nullable|string|max:255',
            'address.billing.city' => 'required|string|max:255',
            'address.billing.postal_code' => 'nullable|string|max:255',
            'address.billing.state' => 'nullable|string|max:255',
            'address.billing.country' => 'nullable|string|max:255',
            'address.shipping.first_name' => 'required|string|max:255',
            'address.shipping.last_name' => 'required|string|max:255',
            'address.shipping.email' => 'required|string|max:255',
            'address.shipping.phone_number' => 'required|string|max:255',
            'address.shipping.street_address' => 'nullable|string|max:255',
            'address.shipping.city' => 'required|string|max:255',
            'address.shipping.postal_code' => 'nullable|string|max:255',
            'address.shipping.state' => 'nullable|string|max:255',
            'address.shipping.country' => 'nullable|string|max:255',

        ];
    }
}
