<?php

namespace App\Services\AAPTFrontier\Actions;

use App\Models\AaptNbnNetworkTerminationDevice;
use App\Services\AAPTFrontier\Actions\GenerateAaptNbnUserNetworkInterface;

class GenerateNbnNetworkTerminationDevice
{
    public static function execute($accessQualID, $nbnNetworkTerminationDevice)
    {

        $aaptNbnNetworkTerminationDevice = new AaptNbnNetworkTerminationDevice();

        $aaptNbnNetworkTerminationDevice->access_qual_id = $accessQualID;

        $aaptNbnNetworkTerminationDevice->ntd_id = $nbnNetworkTerminationDevice->ntdId ?? null;
        $aaptNbnNetworkTerminationDevice->battery_power_unit_installed = $nbnNetworkTerminationDevice->batteryPowerUnitInstalled ?? null;
        $aaptNbnNetworkTerminationDevice->battery_power_unit_monitoring = $nbnNetworkTerminationDevice->batteryPowerUnitMonitoring ?? null;

        $userNetworkInterfaceList = $nbnNetworkTerminationDevice->userNetworkInterfaceList ?? null;

        if (isset($userNetworkInterfaceList)) {
            $userNetworkInterfaces = is_array($userNetworkInterfaceList->userNetworkInterface) ? $userNetworkInterfaceList->userNetworkInterface : [$userNetworkInterfaceList->userNetworkInterface];

            $aaptNbnNetworkTerminationDevice->save();

            $aaptNbnNTDID = $aaptNbnNetworkTerminationDevice->id;

            foreach ($userNetworkInterfaces as $userNetworkInterface) {

                GenerateAaptNbnUserNetworkInterface::execute($aaptNbnNTDID, $userNetworkInterface);
            }
        }

        return $aaptNbnNetworkTerminationDevice;
    }
}
