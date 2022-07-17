<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWebsiteEnquire extends FormRequest
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
            "name"              => 'required',
            "email"             => 'required',
            "phone"             => 'required',
            //"state"             => 'required',
            //"property_type"     => 'required',
            //"best_time_to_call" => 'required',
            //"current_customer"  => 'required',
            //"enquiry_type"      => 'required',
            "message"   => 'required',
            //"site_code"         => 'required'
        ];
    }
}
