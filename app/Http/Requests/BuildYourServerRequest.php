<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildYourServerRequest extends FormRequest
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
            "moveOrConsolidate"   => 'required',
            "urlLink"   => 'nullable',
            "serversToConsolidate" => 'required',
            "isProjectUnderway"   => 'required',
            "preferredDesign" => 'required',
            "teamReadyForAssistance"   => 'required',
            "existingIntranetSite"   => 'required',
            "targetStartDate"   => 'required',
            "bestTimeToCall"   => 'required',
            "companySize"   => 'required',
            "currentCustomer"   => 'required',
            "firstName"   => 'required',
            "lastName"   => 'required',
            "companyName"   => 'required',
            "state"   => 'required',
            "email"   => 'required',
            "phone"   => 'required',
            "message"   => 'required',
            "serviceType" => 'required',
        ];
    }
}
