<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VCProjectPlannerRequest extends FormRequest
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
            "listOfOfficeWorkSites"   => 'required',
            "numberOfMeetingRooms"   => 'required',
            "currentVideoconferencingSolution"   => 'required',
            "preferredVideoconferencingSolution"   => 'required',
            "numberOfDepartments"   => 'required',
            "existingIntranetSite"   => 'required',
            "existingExternalSite"   => 'required',
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
