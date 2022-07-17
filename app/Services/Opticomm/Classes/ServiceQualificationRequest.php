<?php

namespace App\Services\Opticomm\Classes;

class ServiceQualificationRequest
{

    /**
     * @var string $Unit_No
     * @access public
     */
    public $Unit_No = null;

    /**
     * @var string $House_No
     * @access public
     */
    public $House_No = null;

    /**
     * @var string $Lot_No
     * @access public
     */
    public $Lot_No = null;

    /**
     * @var string $Street_Name
     * @access public
     */
    public $Street_Name = null;

    /**
     * @var string $Street_Type
     * @access public
     */
    public $Street_Type = null;

    /**
     * @var string $Suburb
     * @access public
     */
    public $Suburb = null;

    /**
     * @var string $State_Name
     * @access public
     */
    public $State_Name = null;

    /**
     * @var string $Postcode
     * @access public
     */
    public $Postcode = null;

    /**
     * @param string $Street_Name
     * @param string $Suburb
     * @access public
     */
    public function __construct($serviceQualification)
    {
        $streetAddress = $serviceQualification['street_address'];
        $streetAddress = explode(' ', $streetAddress);

        $this->Unit_No = $serviceQualification->unit_number ?? null;
        $this->House_No = $serviceQualification->street_number ?? null;
        $this->Street_Name = $streetAddress[0] ?? null;
        $this->Street_Type = $streetAddress[1] ?? null;
        $this->Suburb = $serviceQualification->suburb ?? null;
        $this->Postcode = $serviceQualification->postcode ?? null;
    }
}
