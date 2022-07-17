<?php

namespace App\Services\Vocus\Classes;

class FTTPNewOrderParams {

    /**
     * @var String $ServiceID
     * @access public
     */
    public $ServiceID = null;

    /**
     * @var String $Realm
     * @access public
     */
    public $Realm = null;

    /**
     * @var String $OrderType
     * @access public
     */
    public $OrderType = null;

    /**
     * @var String $CustomerName
     * @access public
     */
    public $CustomerName = null;

    /**
     * @var String $Phone
     * @access public
     */
    public $Phone = null;

    /**
     * @var String $ServiceType
     * @access public
     */
    public $ServiceType = null;

    /**
     * @var String $CVCID
     * @access public
     */
    public $CVCID = null;

    /**
     * @var String $CTAG
     * @access public
     */
    public $CTAG = null;

    /**
     * @var String $TrafficClass1
     * @access public
     */
    public $TrafficClass1 = null;

    /**
     * @var String $TrafficClass2
     * @access public
     */
    public $TrafficClass2 = null;

    /**
     * @var String $VoicePortID1
     * @access public
     */
    public $VoicePortID1 = null;

    /**
     * @var String $VoicePortID2
     * @access public
     */
    public $VoicePortID2 = null;

    /**
     * @var String $Battery
     * @access public
     */
    public $Battery = null;

    /**
     * @var String $ServiceLevel
     * @access public
     */
    public $ServiceLevel = null;

    /**
     * @var String $DirectoryID
     * @access public
     */
    public $DirectoryID = null;


    /**
     * @var String $LocationReference
     * @access public
     */
    public $LocationReference = null;

    /**
     * @var String $Reference
     * @access public
     */
    public $Reference = null;


    /**
     * @param AccessKey $AccessKey
     * @param AliasKey $AliasKey
     * @param ProductID $ProductID
     * @param PlanID $PlanID
     * @param Scope $Scope
     * @param Profile $Profile
     * @param Parameters $Parameters
     * @access public
     */
    public function __construct($AccessKey, $AliasKey, $ProductID, $PlanID, $Scope, $Profile, $Parameters)
    {
        $this->AccessKey = $AccessKey;
        $this->AliasKey = $AliasKey;
        $this->ProductID = $ProductID;
        $this->PlanID = $PlanID;
        $this->Scope = $Scope;
        $this->Profile = $Profile;
        $this->Parameters = $Parameters;
    }
}
