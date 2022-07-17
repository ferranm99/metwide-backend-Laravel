<?php

namespace App\Traits;

use App\Models\BroadbandServiceOrder;
use App\Models\DataPlan;
use App\Models\ServiceQualification;
use App\Helpers\GeneratePassword;
use App\Models\NBNPortRecord;
use App\Models\VocusCopperPairRecord;
use SebastianBergmann\Type\NullType;

trait CreateServiceQualificationTrait
{
    public function createServiceQualification($broadbandOrderId, $request)
    {
        $locationID = $request->input('directoryId') ?? null;
        $locationID = $locationID === null ? $request->input('locationID') : $locationID;

        $battery = false;
        if ($request->input('qualifyLocation.battery') !== null) {
            $battery = $request->input('qualifyLocation.battery') === 'TRUE' ? true : false;
        }

        $developmentCharge = false;
        if ($request->input('qualifyLocation.developmentCharge') !== null) {
            $developmentCharge = $request->input('qualifyLocation.developmentCharge') === 'TRUE' ? true : false;
        }

        $serviceQualification = ServiceQualification::create([
            'broadband_order_id' => $broadbandOrderId,
            'service_provider' => null,
            'location_id' => $locationID,
            'fnn' => $request->input('FNN') ?? null,
            'long_address' => $request->input('address') ?? null,
            'latitude' => $request->input('latitude') ?? null,
            'longitude' => $request->input('longitude') ?? null,
            'lot_number' => $request->input('nbnServiceAddress.addressMetadata.lot_identifier') ?? null,
            'unit_type' => $request->input('nbnServiceAddress.addressMetadata.unit_type') ?? null,
            'unit_number' => $request->input('nbnServiceAddress.addressMetadata.unit_identifier') ?? null,
            'level_type' => $request->input('nbnServiceAddress.addressMetadata.level_type') ?? null,
            'level_number' => $request->input('nbnServiceAddress.addressMetadata.level_number') ?? null,
            'street_number' => $request->input('nbnServiceAddress.addressMetadata.street_number_1') ?? null,
            'street_address' => $request->input('nbnServiceAddress.addressMetadata.street') ?? null,
            'level_suffix' => null,
            'street_number_suffix' => null,
            'street_number_2' => $request->input('nbnServiceAddress.addressMetadata.street_number_2') ?? null,
            'street_number_suffix_2' => null,
            'street_name' => $request->input('nbnServiceAddress.addressMetadata.street_name') ?? null,
            'street_type' => $request->input('nbnServiceAddress.addressMetadata.street_type') ?? null,
            'street_type_suffix' => $request->input('nbnServiceAddress.addressMetadata.street_suffix') ?? null,
            'suburb' => $request->input('nbnServiceAddress.addressMetadata.locality_name') ?? null,
            'state' => $request->input('nbnServiceAddress.addressMetadata.state_territory') ?? null,
            'postcode' => $request->input('nbnServiceAddress.addressMetadata.postcode') ?? null,
            'estate_name' => null,
            'property_class' => null,
            'stage' => null,
            'directory_tx_id' => null,
            'qualify_tx_id' => $request->input('qualifyLocation.transactionID') ?? null,
            'result' => $request->input('qualifyLocation.result') ?? null,
            'result_code' => null,
            'service_type' => $request->input('qualifyLocation.serviceType') ?? null,
            'service_class' => $request->input('qualifyLocation.serviceClass') ?? null,
            'data_port' => $request->input('qualifyLocation.dataPort') ?? null,
            'voice_port' => $request->input('qualifyLocation.voicePort') ?? null,
            'csa' => $request->input('qualifyLocation.csa') ?? null,
            'cvcid' => $request->input('qualifyLocation.cvcid') ?? null,
            'zone' => $request->input('qualifyLocation.zone') ?? null,
            'voice_cvcid' => $request->input('qualifyLocation.voiceCVCID') ?? null,
            'traffice_class_1' => $request->input('qualifyLocation.trafficClass1') ?? null,
            'traffice_class_2' => $request->input('qualifyLocation.trafficClass2') ?? null,
            'traffice_class_3' => $request->input('qualifyLocation.trafficClass3') ?? null,
            'traffice_class_4' => $request->input('qualifyLocation.trafficClass4') ?? null,
            'available_ctag' => $request->input('qualifyLocation.availableCTAG') ?? null,
            'stag' => $request->input('qualifyLocation.stag') ?? null,
            'battery' => $battery,
            'connection_type' => $request->input('qualifyLocation.connectionType') ?? null,
            'development_charge' => $developmentCharge,
            'activation_date' => $request->input('qualifyLocation.activationDate') ?? null,
            'copper_disconnection_date' => $request->input('qualifyLocation.copperDisconnectionDate') ?? null,
            'ntdid' => $request->input('qualifyLocation.ntdid') ?? null,
        ]);

        if ($request->input('qualifyLocation.copperPairRecord') ?? null) {

            foreach ($request->input('qualifyLocation.copperPairRecord') as $copperPairRecord) {
                $copperRecord = $this->createCopperPairRecord($serviceQualification->id, $copperPairRecord);
            }
        };

        if ($request->input('qualifyLocation.nbnPortRecord') ?? null) {

            foreach ($request->input('qualifyLocation.nbnPortRecord') as $nbnPortRecord) {
                $portRecord = $this->createNbnPortRecord($serviceQualification->id, $nbnPortRecord);
            }
        };

        return $serviceQualification;
    }

    private function createCopperPairRecord($serviceQualificationId, $copperPairRecord)
    {
        $potsMatch = false;
        if ($copperPairRecord['potsMatch'] !== null) {
            $potsMatch = $copperPairRecord['potsMatch'] === 'TRUE' ? true : false;
        }

        $networkCoExist = false;
        if ($copperPairRecord['networkCoExist'] !== null) {
            $networkCoExist = $copperPairRecord['networkCoExist'] === 'TRUE' ? true : false;
        }

        $copperRecord = VocusCopperPairRecord::create([
            'service_qualification_id' => $serviceQualificationId,
            'copper_pair_id' => $copperPairRecord['copperPairID'] ?? null,
            'copper_pair_status' => $copperPairRecord['copperPairStatus'] ?? null,
            'nbn_service_status' => $copperPairRecord['nbnServiceStatus'] ?? null,
            'pots_interconnect' => $copperPairRecord['potsInterconnect'] ?? null,
            'pots_match' => $potsMatch,
            'fnn' => $copperPairRecord['FNN'] ?? null,
            'upload_speed' => $copperPairRecord['uploadSpeed'] ?? null,
            'download_speed' => $copperPairRecord['downloadSpeed'] ?? null,
            'network_co_exist' => $networkCoExist,
        ]);

        return $copperRecord;
    }

    private function createNbnPortRecord($serviceQualificationId, $nbnPortRecord)
    {
        $available = false;
        if ($nbnPortRecord['available'] !== null) {
            $available = $nbnPortRecord['available'] === 'TRUE' ? true : false;
        }

        $portRecord = NBNPortRecord::create([
            'service_qualification_id' => $serviceQualificationId,
            'ntdid' => $nbnPortRecord['ntdid'] ?? null,
            'port_number' => $nbnPortRecord['portNumber'] ?? null,
            'port_name' => $nbnPortRecord['portName'] ?? null,
            'available' => $available,
            'port_type' => $nbnPortRecord['portType'] ?? null,
        ]);

        return $portRecord;
    }
}
