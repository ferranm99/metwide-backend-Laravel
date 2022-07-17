<?php

namespace App\Services\AAPTFrontier\Actions;

use App\Models\AaptNbnCopperPair;

class GenerateAaptNbnCopperPair
{
    public static function execute($accessQualID, $nbnCopperPair)
    {

        $aaptNbnCopperPair = new AaptNbnCopperPair();

        $aaptNbnCopperPair->access_qual_id = $accessQualID;

        $aaptNbnCopperPair->copper_pair_id = $nbnCopperPair->ID ?? null;
        $aaptNbnCopperPair->pots_interconnect = $nbnCopperPair->POTSInterconnect ?? null;
        $aaptNbnCopperPair->is_line_in_use = $nbnCopperPair->isLineInUse ?? null;
        $aaptNbnCopperPair->is_copper_active = $nbnCopperPair->isCopperActive ?? null;
        $aaptNbnCopperPair->tc4_downstream_upper_rate = $nbnCopperPair->TC4DownstreamUpperRate ?? null;
        $aaptNbnCopperPair->tc4_downstream_lower_rate = $nbnCopperPair->TC4DownstreamLowerRate ?? null;
        $aaptNbnCopperPair->tc4_upstream_lower_rate = $nbnCopperPair->TC4UpstreamUpperRate ?? null;
        $aaptNbnCopperPair->tc4_upstream_upper_rate = $nbnCopperPair->TC4UpstreamLowerRate ?? null;
        $aaptNbnCopperPair->is_coexisting_network = $nbnCopperPair->isCoexistingNetwork ?? null;
        $aaptNbnCopperPair->is_pots_interconnect_match = $nbnCopperPair->isPOTSInterconnectMatch ?? null;
        $aaptNbnCopperPair->serviceability_class = $nbnCopperPair->ServiceabilityClass ?? null;
        $aaptNbnCopperPair->service_type = $nbnCopperPair->ServiceType ?? null;
        $aaptNbnCopperPair->service_provider_id = $nbnCopperPair->ServiceProviderID ?? null;
        $aaptNbnCopperPair->subsequent_installation_charge_applies = $nbnCopperPair->SubsequentInstallationChargeApplies ?? null;

        $aaptNbnCopperPair->save();

        return $aaptNbnCopperPair;
    }
}
