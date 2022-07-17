<?php

namespace App\Traits;

use App\Models\BroadbandServiceOrder;
use App\Models\DataPlan;
use App\Models\ServiceQualification;
use App\Helpers\GeneratePassword;
use App\Models\DataServiceModification;
use App\Models\VocusDailyStatusReport;
use SebastianBergmann\Type\NullType;

trait CreateDataServiceModificationTrait
{
    public function createDataServiceModification($serviceOrder, $request)
    {

        $newSpeed =  str_replace(' Mbps', '', $request->input('newSpeed'));

        $dataPlan = DataPlan::where('speed', $newSpeed)
            ->where('service_category_id', 7)
            ->first();

        $dataPlanID = $dataPlan->id;

        $vocusService = VocusDailyStatusReport::where('id', $request->input('vocusServiceID'))->first();

        $currentSpeed = $vocusService->speed;

        $serviceOrderReference = $serviceOrder->order_reference . '-1';

        $broadbandServiceOrder = DataServiceModification::create([
            'service_order_id' => $serviceOrder->id,
            'vocus_service_id' => $request->input('vocusServiceID'),
            'data_plan_id' => $dataPlanID,
            'current_speed' => $currentSpeed,
            'order_reference' => $serviceOrderReference,
            'provisioning_status' => 'New Order',
        ]);

        return $broadbandServiceOrder;
    }

    private function getDataPlan($speed, $dataAllowance)
    {
        if ($dataAllowance != 'Unlimited') {
            $data = explode(" ", $dataAllowance);
            $dataAllowance = $data[0];
        }

        $dataPlan = DataPlan::where('service_category_id', 1)->where('download_speed', $speed)->where('data_allowance', $dataAllowance)->first();

        return $dataPlan->id ?? null;
    }

    private function getBroadbaneUsername($orderReferenceNumber)
    {

        $username = str_replace('-', '', strtolower($orderReferenceNumber)) . '@nbn.alphacall.com.au';

        return $username;
    }
}
