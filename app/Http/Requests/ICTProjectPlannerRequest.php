<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ICTProjectPlannerRequest extends FormRequest
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
            "projectDescription"   => 'required',
            "expectedTimeToComplete"   => 'required',
            "preferredSolution"   => 'required',
            "willIncludeInternalTesters"   => 'required',
            "isProjectUnderway"   => 'required',
            "targetStartDate"   => 'required',
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
