<?php

namespace App\Traits;

use Illuminate\Support\Str;

use App\Models\MobilePlan;
use App\Models\ModemOrder;
use App\Models\Product;
use SebastianBergmann\Type\NullType;

trait CreateModemOrderTrait
{
    public function createModemOrder($serviceOrder, $request)
    {

        $modemModelId = $this->getModemType($request->input('selectedModemModel'));

        $deliveryFirstName = $request->input('deliveryFirstName');
        $deliveryLastName = $request->input('deliveryLastName');
        $deliveryName = implode(' ', [$deliveryFirstName, $deliveryLastName]);

        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $generatedBy = implode(' ', [$firstName, $lastName]);

        $modemOrder = ModemOrder::create([
            'service_order_id' => $serviceOrder->id,
            'product_id' => $modemModelId,
            'order_number' => $serviceOrder->order_reference,
            'order_date' => now(),
            'first_name' => $deliveryFirstName,
            'last_name' => $deliveryLastName,
            'delivery_name' => $deliveryName,
            'company' => null,
            'street_address' => $request->input('streetAddress'),
            'suburb' => $request->input('suburb'),
            'state' => $request->input('state'),
            'postcode' => $request->input('postcode'),
            'customer_email' => $request->input('email') ?? null,
            'customer_phone_number' => $request->input('phoneNumber') ,
            'product_required' => 0,
            'internet_connection' => null,
            'vlan_id' => '',
            'isp_user_account' => null,
            'isp_user_password' => null,
            'wifi_name' => null,
            'wifi_password' => null,
            'voip_user_name_account_1' => null,
            'voip_password_account_1' => null,
            'voip_user_name_account_2' => null,
            'voip_password_account_2' => null,
            'sip_roxy' => null,
            'sip_port' => null,
            'remote_access' =>null,
            'local_management_port_number' => null,
            'remote_management_port_number' => null,
            'remote_ip_address' => null,
            'local_icmp_ping' => null,
            'remote_icmp_ping' => null,
            'modem_user' => null,
            'modem_password' => null,
            'notes' => null,
            'mac_address' => null,
            'serial_number' => null,
            'tracking_number' => null,
            'generated_by' => $generatedBy,
            'modem_order_sent' => 0,
            'modem_order_filename' => null,
        ]);
        return $modemOrder;
    }

    private function getModemType($code)
    {

        $product = Product::where('code', $code)->first();

        return $product->id ?? null;
    }
}
