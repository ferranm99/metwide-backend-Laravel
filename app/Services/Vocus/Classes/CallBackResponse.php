<?php

namespace App\Services\Vocus\Classes;

class CallBackResponse
{

    /**
     * @var TransactionID $TransactionID
     * @access public
     */
    public $TransactionID = null;

    /**
     * @param TransactionID $TransactionID
     * @access public
     */
    public function __construct($TransactionID)
    {
      $this->TransactionID = $TransactionID;
    }

}
