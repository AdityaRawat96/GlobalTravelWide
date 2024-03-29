<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow the user to store a new invoice if they have role of admin or digital
        return $this->user()->role === 'admin' || $this->user()->role === 'digital';
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
            'due_date' => ['required', 'date'],
            'departure_date' => ['required', 'date'],
            'invoice_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'product' => ['required', 'array'],
            'product.*' => ['required', 'integer'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer'],
            'cost' => ['required', 'array'],
            'cost.*' => ['required', 'numeric'],
            'price' => ['required', 'array'],
            'price.*' => ['required', 'numeric'],
            'payment_mode' => ['required', 'array'],
            'payment_mode.*' => ['required', 'string'],
            'payment_date' => ['required', 'array'],
            'payment_date.*' => ['required', 'date'],
            'payment_amount' => ['required', 'array'],
            'payment_amount.*' => ['required', 'numeric'],
            'file' => ['array', 'max:5'],
            'file.*' => ['file', 'max:5120'],
        ];
    }
}