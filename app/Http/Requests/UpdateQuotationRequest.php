<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow the user to update a new quotation if they have role of admin or digital
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
            'quotation_date' => ['required', 'date'],
            'airline_notes' => ['nullable', 'string', 'max:2000'],
            'hotel_notes' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'airline_name' => ['array'],
            'airline_name.*' => ['string'],
            'departure_airport' => ['array'],
            'departure_airport.*' => ['string'],
            'arrival_airport' => ['array'],
            'arrival_airport.*' => ['string'],
            'departure_time' => ['array'],
            'departure_time.*' => ['datetime'],
            'arrival_time' => ['array'],
            'arrival_time.*' => ['datetime'],
            'hotel_name' => ['array'],
            'hotel_name.*' => ['string'],
            'checkin_time' => ['array'],
            'checkin_time.*' => ['datetime'],
            'checkout_time' => ['array'],
            'checkout_time.*' => ['datetime'],
            'file' => ['array', 'max:5'],
            'file.*' => ['file', 'max:5120'],
        ];
    }
}