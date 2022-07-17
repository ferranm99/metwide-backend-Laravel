<?php

namespace App\Services\Vocus\Classes;

class Param
{

    /**
     * @var string $_
     * @access public
     */
    public $_ = null;

    /**
     * @var string $id
     * @access public
     */
    public $id = null;

    /**
     * @param string $_
     * @param string $id
     * @access public
     */
    public function __construct($_, $id)
    {
        $this->_ = $_;
        $this->id = $id;
    }
}
