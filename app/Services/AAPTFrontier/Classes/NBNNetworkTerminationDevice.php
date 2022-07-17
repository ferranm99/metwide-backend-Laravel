<?php

namespace App\Services\AAPTFrontier\Classes;

class NBNNetworkTerminationDevice
{

    /**
     * @var NtdId $ntdId
     * @access public
     */
    public $ntdId = null;

    /**
     * @var YesNo $batteryPowerUnitInstalled
     * @access public
     */
    public $batteryPowerUnitInstalled = null;

    /**
     * @var BatteryPowerUnitMonitoring $batteryPowerUnitMonitoring
     * @access public
     */
    public $batteryPowerUnitMonitoring = null;

    /**
     * @var NBNUserNetworkInterfaceList $userNetworkInterfaceList
     * @access public
     */
    public $userNetworkInterfaceList = null;

    /**
     * @param NtdId $ntdId
     * @param YesNo $batteryPowerUnitInstalled
     * @param BatteryPowerUnitMonitoring $batteryPowerUnitMonitoring
     * @param NBNUserNetworkInterfaceList $userNetworkInterfaceList
     * @access public
     */
    public function __construct($ntdId, $batteryPowerUnitInstalled, $batteryPowerUnitMonitoring, $userNetworkInterfaceList)
    {
      $this->ntdId = $ntdId;
      $this->batteryPowerUnitInstalled = $batteryPowerUnitInstalled;
      $this->batteryPowerUnitMonitoring = $batteryPowerUnitMonitoring;
      $this->userNetworkInterfaceList = $userNetworkInterfaceList;
    }

}
