<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ITHealthCheckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "firstName"              => 'required',
            "lastName"              => 'required',
            "companyName"              => 'required',
            "position"             => 'required',
            "email"             => 'required',
            "phone"             => 'required',
            "message"   => 'required',
        ];
    }
}
