<?php

namespace App\Services\Vocus\Classes;

class SetRequest
{

    /**
     * @var AccessKey $AccessKey
     * @access public
     */
    public $AccessKey = null;

    /**
     * @var AliasKey $AliasKey
     * @access public
     */
    public $AliasKey = null;

    /**
     * @var ProductID $ProductID
     * @access public
     */
    public $ProductID = null;

    /**
     * @var PlanID $PlanID
     * @access public
     */
    public $PlanID = null;

    /**
     * @var Scope $Scope
     * @access public
     */
    public $Scope = null;

    /**
     * @var Profile $Profile
     * @access public
     */
    public $Profile = null;

    /**
     * @var Parameters $Parameters
     * @access public
     */
    public $Parameters = null;

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
