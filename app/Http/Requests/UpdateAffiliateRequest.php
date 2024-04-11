<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAffiliateRequest extends FormRequest
{
    /**
     * Determine if the affiliate is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow the affiliate to update a affiliate if they have role of admin or the affiliate is the same as the authenticated affiliate
        return $this->user()->role === 'admin' || $this->user()->id === $this->route('affiliate')->added_by;
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('affiliates')->ignore($this->affiliate->id)],
            'phone' => ['required', 'string', 'max:255'],
            'commission' => ['required', 'string', 'max:255'],
        ];
    }
}
