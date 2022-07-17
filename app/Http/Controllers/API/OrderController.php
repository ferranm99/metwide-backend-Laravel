<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\CreateServiceOrderTrait;
use App\Traits\CreateDataServiceModificationTrait;
use App\Traits\CreateOrderAddressTrait;
use App\Traits\CreateModemOrderTrait;
use App\Traits\CreateVoiceServiceOrderTrait;
use App\Traits\CreateBroadbandServiceOrderTrait;
use App\Traits\CreateServiceQualificationTrait;

class OrderController extends Controller
{
    use CreateServiceOrderTrait, CreateDataServiceModificationTrait, CreateOrderAddressTrait, CreateModemOrderTrait, CreateVoiceServiceOrderTrait, CreateBroadbandServiceOrderTrait, CreateServiceQualificationTrait;

    public function submitModemOrder(Request $request)
    {
        $ucn = $request->get('ucn');

        $serviceOrder = $this->createServiceOrderPortal($request);

        $response = $this->createOrderAddress($serviceOrder, $request);

        $modemOrder = $this->createModemOrder($serviceOrder, $request);

        return response()->json([
            'status' => 'success',
            'orderReference' => $serviceOrder->order_reference
        ]);
    }

    public function submitNewOrder(Request $request)
    {
        $ucn = $request->get('ucn');

        $orderType = $request->get('orderType');

        // return response()->json($request->all());

        $serviceOrder = $this->createServiceOrderPortal($request);

        $metwideToBill = $request->get('metwideToBill') ? $request->get('metwideToBill') : false;

        if ($metwideToBill) {
            $response = $this->createOrderAddress($serviceOrder, $request);
        } else {
            $response = $this->createOrderAddress($serviceOrder, $request);
        }

        $selectedNbnPortRecord = $request->input('selectedNbnPortRecord') >= 0 ? $request->input('selectedNbnPortRecord') : null;
        $nbnPortRecord =  $request->input('nbnPortRecord') ?? null;


       /* return response()->json([
            'status' => '',
            'orderReference' => $nbnPortRecord[$selectedNbnPortRecord]['ntdid']
        ]);
*/
        if ($orderType === 'VoIP') {
            $voiceOrder = $this->createVoiceServiceOrderPortal($serviceOrder, $request);
        }

        if ($orderType === 'nbn') {
            $broadbandOrder = $this->createBroadbandServiceOrderPortal($serviceOrder, $request);

            $serviceQualification = $this->createServiceQualification($broadbandOrder->id, $request);

        }


        return response()->json([
            'status' => 'success',
           'orderReference' => $serviceOrder->order_reference
        ]);
    }
}
