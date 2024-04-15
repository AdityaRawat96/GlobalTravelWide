<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRefundRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow the user to store a new refund if they have role of admin or staff
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
            'ref_number' => ['nullable', 'string', 'max:255'],
            'company_id' => 'required',
            'customer_id' => 'required',
            'notes' => ['nullable', 'string', 'max:2000'],
            'product' => ['required', 'array'],
            'product.*' => ['required', 'integer'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer'],
            'cost' => ['required', 'array'],
            'cost.*' => ['required', 'numeric'],
            'price' => ['required', 'array'],
            'price.*' => ['required', 'numeric'],
            'payment_mode' => ['array'],
            'payment_mode.*' => ['string'],
            'payment_date' => ['array'],
            'payment_date.*' => ['date'],
            'payment_amount' => ['array'],
            'payment_amount.*' => ['numeric'],
            'file' => ['array', 'max:5'],
            'file.*' => ['file', 'max:5120'],
        ];
    }
}
