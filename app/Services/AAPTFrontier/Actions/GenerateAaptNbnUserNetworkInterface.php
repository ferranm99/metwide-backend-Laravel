<?php

namespace App\Services\AAPTFrontier\Actions;

use App\Models\AaptNbnUserNetworkInterface;

class GenerateAaptNbnUserNetworkInterface
{
    public static function execute($nbnNTDID, $userNetworkInterface)
    {

        $aaptNbnUserNetworkInterface = new AaptNbnUserNetworkInterface();

        $aaptNbnUserNetworkInterface->nbn_ntd_id = $nbnNTDID;

        $aaptNbnUserNetworkInterface->uni_id = $userNetworkInterface->uniId ?? null;
        $aaptNbnUserNetworkInterface->uni_type = $userNetworkInterface->uniType ?? null;
        $aaptNbnUserNetworkInterface->port_id = $userNetworkInterface->portId ?? null;
        $aaptNbnUserNetworkInterface->status = $userNetworkInterface->status ?? null;
        $aaptNbnUserNetworkInterface->service_provider_id = $userNetworkInterface->serviceProviderId ?? null;
        $aaptNbnUserNetworkInterface->product_instance_id = $userNetworkInterface->productInstanceId ?? null;

        $aaptNbnUserNetworkInterface->save();

        return $aaptNbnUserNetworkInterface;
    }
}
