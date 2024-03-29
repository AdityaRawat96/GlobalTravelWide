<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the customer is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow the customer to update a customer if they have role of admin or the customer is the same as the authenticated customer
        return $this->user()->role === 'admin' || $this->user()->id === $this->route('customer')->added_by;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('customers')->ignore($this->customer->id)],
            'phone' => ['required', 'string', 'max:255'],
        ];
    }
}
