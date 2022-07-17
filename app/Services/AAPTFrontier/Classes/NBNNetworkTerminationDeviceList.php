<?php

namespace App\Services\AAPTFrontier\Classes;

class NBNNetworkTerminationDeviceList
{

    /**
     * @var NBNNetworkTerminationDevice[] $nbnNetworkTerminationDevice
     * @access public
     */
    public $nbnNetworkTerminationDevice = null;

    /**
     * @param NBNNetworkTerminationDevice[] $nbnNetworkTerminationDevice
     * @access public
     */
    public function __construct($nbnNetworkTerminationDevice)
    {
      $this->nbnNetworkTerminationDevice = $nbnNetworkTerminationDevice;
    }

}
