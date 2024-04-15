<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->role === 'admin' || $this->user()->role === 'staff';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_id' => ['required', 'integer', 'max:255'],
            'refund_id' => ['required', 'integer', 'max:255'],
            'catalogue_id' => ['required', 'integer', 'max:255'],
            'quantity' => ['required', 'integer', 'max:255'],
            'cost_price' => ['required', 'float', 'max:255'],
            'selling_price' => ['required', 'float', 'max:255'],
            'revenue' => ['required', 'float', 'max:255'],
        ];
    }
}
