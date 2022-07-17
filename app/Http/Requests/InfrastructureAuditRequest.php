<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfrastructureAuditRequest extends FormRequest
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
            "companySize"             => 'required',
            "email"             => 'required',
            "phone"             => 'required',
            "message"   => 'required',
            "itDevicesList" => 'required'
        ];
    }
}
