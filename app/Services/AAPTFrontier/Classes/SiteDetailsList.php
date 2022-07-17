<?php

namespace App\Helpers\AAPTFrontier\Classes;

class SiteDetailsList
{

    /**
     * @var SiteDetails[] $siteDetails
     * @access public
     */
    public $siteDetails = null;

    /**
     * @param SiteDetails[] $siteDetails
     * @access public
     */
    public function __construct($siteDetails)
    {
      $this->siteDetails = $siteDetails;
    }

}
