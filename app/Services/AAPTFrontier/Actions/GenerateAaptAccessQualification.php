<?php

namespace App\Services\AAPTFrontier\Actions;

use App\Models\AaptAccessQualification;

use Barryvdh\Debugbar\Facade as Debugbar;
use Exception;

class GenerateAaptAccessQualification
{
    public static function execute($aaptSQID, $accessQualification)
    {

        $aaptAccessQualification = new AaptAccessQualification();

        $aaptAccessQualification->aapt_sq_id = $aaptSQID;
        $aaptAccessQualification->access_qualification_id = $accessQualification->id;
        $aaptAccessQualification->qualification_result = $accessQualification->qualificationResult ?? null;
        $aaptAccessQualification->access_method = $accessQualification->accessMethod ?? null;
        $aaptAccessQualification->access_type = $accessQualification->accessType ?? null;
        $aaptAccessQualification->price_zone = $accessQualification->priceZone ?? null;
        $aaptAccessQualification->maximum_down_bandwidth = $accessQualification->maximumDownBandwidth->value . $accessQualification->maximumDownBandwidth->quantifier;
        $aaptAccessQualification->maximum_up_bandwidth = $accessQualification->maximumUpBandwidth->value . $accessQualification->maximumUpBandwidth->quantifier;

        $availableServiceSpeeds = '';

        $serviceSpeeds = $accessQualification->availableServiceSpeeds->serviceSpeed ?? [];
        $serviceSpeeds = is_array($serviceSpeeds) ? $serviceSpeeds : [$serviceSpeeds];

        $first = true;
        foreach ($serviceSpeeds as $serviceSpeed) {
            if ($first === true) {
                $first = false;
                $availableServiceSpeeds = $serviceSpeed->serviceSpeed . ' | ' . $serviceSpeed->status;
            }
            else {
                $availableServiceSpeeds = $availableServiceSpeeds . ', ' . $serviceSpeed->serviceSpeed . ' | ' . $serviceSpeed->status;
            }

        }

        $aaptAccessQualification->available_service_speeds = $availableServiceSpeeds;

        $nbnNewDevelopmentsChargeApplies = $accessQualification->nbnNewDevelopmentsChargeApplies ?? '';

        $aaptAccessQualification->nbn_new_developments_charge_applies = strtolower($nbnNewDevelopmentsChargeApplies) === 'yes' ? 1 : 0;

        $aaptAccessQualification->save();

        return $aaptAccessQualification;

    }
}
