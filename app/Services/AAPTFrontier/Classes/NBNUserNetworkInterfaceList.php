<?php

namespace App\Services\AAPTFrontier\Classes;

class NBNUserNetworkInterfaceList
{

    /**
     * @var NBNUserNetworkInterfaceDetails[] $userNetworkInterface
     * @access public
     */
    public $userNetworkInterface = null;

    /**
     * @param NBNUserNetworkInterfaceDetails[] $userNetworkInterface
     * @access public
     */
    public function __construct($userNetworkInterface)
    {
      $this->userNetworkInterface = $userNetworkInterface;
    }

}
