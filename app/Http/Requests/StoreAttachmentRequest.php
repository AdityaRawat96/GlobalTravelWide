<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only admin can create an attachment
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
            'ref_id' => 'nullable',
            'file' => 'required|file|max:10240',
        ];
    }
}
