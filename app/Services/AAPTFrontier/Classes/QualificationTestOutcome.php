<?php

namespace App\Helpers\AAPTFrontier\Classes;

class QualificationTestOutcome
{

    /**
     * @var TestNumber $testNumber
     * @access public
     */
    public $testNumber = null;

    /**
     * @var TestDescription $testDescription
     * @access public
     */
    public $testDescription = null;

    /**
     * @var TestResponse $testResponse
     * @access public
     */
    public $testResponse = null;

    /**
     * @var TestResult $testResult
     * @access public
     */
    public $testResult = null;

    /**
     * @param TestNumber $testNumber
     * @param TestDescription $testDescription
     * @param TestResponse $testResponse
     * @param TestResult $testResult
     * @access public
     */
    public function __construct($testNumber, $testDescription, $testResponse, $testResult)
    {
      $this->testNumber = $testNumber;
      $this->testDescription = $testDescription;
      $this->testResponse = $testResponse;
      $this->testResult = $testResult;
    }

}
