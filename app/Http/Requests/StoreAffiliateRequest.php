<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAffiliateRequest extends FormRequest
{
    /**
     * Determine if the affiliate is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow the affiliate to store a new affiliate if they have role of admin or staff
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:affiliates'],
            'phone' => ['required', 'string', 'max:255'],
        ];
    }
}