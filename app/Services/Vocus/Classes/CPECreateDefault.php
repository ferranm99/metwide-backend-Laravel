<?php

namespace App\Services\Vocus\Classes;

class CPECreateDefault
{

    /**
     * @var String $ServiceID
     * @access public
     */
    public $ServiceID = null;

    /**
     * @var String $Username
     * @access public
     */
    public $Username = null;

    /**
     * @var String $Password
     * @access public
     */
    public $Password = null;

    /**
     * @var String $SIP1Username
     * @access public
     */
    public $SIPUsername = null;

    /**
     * @var String $SIP.1.Username
     * @access public
     */
    public $Phone = null;

    /**
     * @var String $ServiceType
     * @access public
     */
    public $ServiceType = null;

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
     * @var String $CTAG
     * @access public
     */
    public $Battery = null;

    /**
     * @var String $CTAG
     * @access public
     */
    public $ServiceLevel = null;

    /**
     * @var String $CTAG
     * @access public
     */
    public $DirectoryID = null;


    /**
     * @var String $CTAG
     * @access public
     */
    public $LocationReference = null;

    /**
     * @var String $CTAG
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
