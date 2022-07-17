<?php

namespace App\Services\Opticomm\Classes;

use App\Services\Opticomm\Classes\PortUtilisation;

class ServiceQualificationResponse
{

    /**
     * @var string $statusCode
     * @access public
     */
    public $statusCode = null;

    /**
     * @var int $resultCode
     * @access public
     */
    public $resultCode = null;

    /**
     * @var string $propertyID
     * @access public
     */
    public $propertyID = null;

    /**
     * @var string $unitNo
     * @access public
     */
    public $unitNo = null;

    /**
     * @var string $houseNo
     * @access public
     */
    public $houseNo = null;

    /**
     * @var string $lotNo
     * @access public
     */
    public $lotNo = null;

    /**
     * @var string $streetName
     * @access public
     */
    public $streetName = null;

    /**
     * @var string $streetType
     * @access public
     */
    public $streetType = null;

    /**
     * @var string $suburb
     * @access public
     */
    public $suburb = null;

    /**
     * @var string $stateName
     * @access public
     */
    public $stateName = null;

    /**
     * @var string $postcode
     * @access public
     */
    public $postcode = null;

    /**
     * @var string $estateName
     * @access public
     */
    public $estateName = null;

    /**
     * @var string $stage
     * @access public
     */
    public $stage = null;

    /**
     * @var string $propertyClass
     * @access public
     */
    public $propertyClass = null;

    /**
     * @var PortUtilisation[] $portUtilisation
     * @access public
     */
    public $portUtilisation = null;

    /**
     * @access public
     */
    public function __construct($responseItem)
    {
        $this->statusCode = $responseItem->Status_Code ?? null;
        $this->resultCode = $responseItem->Result_Code ?? null;
        $this->propertyID = $responseItem->propertyID ?? null;
        $this->unitNo = $responseItem->unitNo ?? null;
        $this->houseNo = $responseItem->houseNo ?? null;
        $this->lotNo = $responseItem->Lot_No ?? null;
        $this->streetName = $responseItem->Street_Name ?? null;
        $this->suburb = $responseItem->Suburb ?? null;
        $this->stateName = $responseItem->State_Name ?? null;
        $this->postcode = $responseItem->Postcode ?? null;
        $this->estateName = $responseItem->Estate_Name ?? null;
        $this->stage = $responseItem->Stage ?? null;
        $this->propertyClass = $responseItem->Property_Class ?? null;

        $portUtilisation = $responseItem->Port_Utilisation->PortUtilisation ?? null;

        if (isset($portUtilisation)) {
            $portUtilisation = is_array($portUtilisation) ? $portUtilisation : [$portUtilisation];

            foreach ($portUtilisation as $port) {
                $this->portUtilisation[] = new PortUtilisation($port);
            }

        }
        else {
            $this->portUtilisation = null;
        }
    }

}
