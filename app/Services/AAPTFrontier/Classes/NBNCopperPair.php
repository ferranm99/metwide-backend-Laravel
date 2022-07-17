<?php

namespace App\Services\AAPTFrontier\Classes;

class NBNCopperPair
{

    /**
     * @var string $ID
     * @access public
     */
    public $ID = null;

    /**
     * @var string $POTSInterconnect
     * @access public
     */
    public $POTSInterconnect = null;

    /**
     * @var boolean $isLineInUse
     * @access public
     */
    public $isLineInUse = null;

    /**
     * @var boolean $isCopperActive
     * @access public
     */
    public $isCopperActive = null;

    /**
     * @var string $TC4DownstreamUpperRate
     * @access public
     */
    public $TC4DownstreamUpperRate = null;

    /**
     * @var string $TC4DownstreamLowerRate
     * @access public
     */
    public $TC4DownstreamLowerRate = null;

    /**
     * @var string $TC4UpstreamUpperRate
     * @access public
     */
    public $TC4UpstreamUpperRate = null;

    /**
     * @var string $TC4UpstreamLowerRate
     * @access public
     */
    public $TC4UpstreamLowerRate = null;

    /**
     * @var boolean $isCoexistingNetwork
     * @access public
     */
    public $isCoexistingNetwork = null;

    /**
     * @var boolean $isPOTSInterconnectMatch
     * @access public
     */
    public $isPOTSInterconnectMatch = null;

    /**
     * @var string $ServiceabilityClass
     * @access public
     */
    public $ServiceabilityClass = null;

    /**
     * @var string $ServiceType
     * @access public
     */
    public $ServiceType = null;

    /**
     * @var string $ServiceProviderID
     * @access public
     */
    public $ServiceProviderID = null;

    /**
     * @var boolean $SubsequentInstallationChargeApplies
     * @access public
     */
    public $SubsequentInstallationChargeApplies = null;

    /**
     * @param string $ID
     * @param string $POTSInterconnect
     * @param boolean $isLineInUse
     * @param boolean $isCopperActive
     * @param string $TC4DownstreamUpperRate
     * @param string $TC4DownstreamLowerRate
     * @param string $TC4UpstreamUpperRate
     * @param string $TC4UpstreamLowerRate
     * @param boolean $isCoexistingNetwork
     * @param boolean $isPOTSInterconnectMatch
     * @param string $ServiceabilityClass
     * @param string $ServiceType
     * @param string $ServiceProviderID
     * @param boolean $SubsequentInstallationChargeApplies
     * @access public
     */
    public function __construct($ID, $POTSInterconnect, $isLineInUse, $isCopperActive, $TC4DownstreamUpperRate, $TC4DownstreamLowerRate, $TC4UpstreamUpperRate, $TC4UpstreamLowerRate, $isCoexistingNetwork, $isPOTSInterconnectMatch, $ServiceabilityClass, $ServiceType, $ServiceProviderID, $SubsequentInstallationChargeApplies)
    {
      $this->ID = $ID;
      $this->POTSInterconnect = $POTSInterconnect;
      $this->isLineInUse = $isLineInUse;
      $this->isCopperActive = $isCopperActive;
      $this->TC4DownstreamUpperRate = $TC4DownstreamUpperRate;
      $this->TC4DownstreamLowerRate = $TC4DownstreamLowerRate;
      $this->TC4UpstreamUpperRate = $TC4UpstreamUpperRate;
      $this->TC4UpstreamLowerRate = $TC4UpstreamLowerRate;
      $this->isCoexistingNetwork = $isCoexistingNetwork;
      $this->isPOTSInterconnectMatch = $isPOTSInterconnectMatch;
      $this->ServiceabilityClass = $ServiceabilityClass;
      $this->ServiceType = $ServiceType;
      $this->ServiceProviderID = $ServiceProviderID;
      $this->SubsequentInstallationChargeApplies = $SubsequentInstallationChargeApplies;
    }

}
