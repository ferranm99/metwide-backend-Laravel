<?php

namespace App\Services\AAPTFrontier\Classes;

class NBNUserNetworkInterfaceDetails
{

    /**
     * @var UniId $uniId
     * @access public
     */
    public $uniId = null;

    /**
     * @var UniType $uniType
     * @access public
     */
    public $uniType = null;

    /**
     * @var PortId $portId
     * @access public
     */
    public $portId = null;

    /**
     * @var Status $status
     * @access public
     */
    public $status = null;

    /**
     * @var ServiceProviderId $serviceProviderId
     * @access public
     */
    public $serviceProviderId = null;

    /**
     * @var ProductInstanceId $productInstanceId
     * @access public
     */
    public $productInstanceId = null;

    /**
     * @param UniId $uniId
     * @param UniType $uniType
     * @param PortId $portId
     * @param Status $status
     * @param ServiceProviderId $serviceProviderId
     * @param ProductInstanceId $productInstanceId
     * @access public
     */
    public function __construct($uniId, $uniType, $portId, $status, $serviceProviderId, $productInstanceId)
    {
      $this->uniId = $uniId;
      $this->uniType = $uniType;
      $this->portId = $portId;
      $this->status = $status;
      $this->serviceProviderId = $serviceProviderId;
      $this->productInstanceId = $productInstanceId;
    }

}
