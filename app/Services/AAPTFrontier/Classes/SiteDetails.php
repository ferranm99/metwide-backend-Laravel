<?php

namespace App\Helpers\AAPTFrontier\Classes;

class SiteDetails
{

    /**
     * @var SiteAddress $siteAddress
     * @access public
     */
    public $siteAddress = null;

    /**
     * @var Contact $siteContact
     * @access public
     */
    public $siteContact = null;

    /**
     * @param SiteAddress $siteAddress
     * @param Contact $siteContact
     * @access public
     */
    public function __construct($siteAddress, $siteContact)
    {
      $this->siteAddress = $siteAddress;
      $this->siteContact = $siteContact;
    }

}
