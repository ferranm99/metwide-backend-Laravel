<?php

namespace App\Services\Opticomm\SoapClient;

use Exception;

class OpticommConsumer
{

    protected $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    public function __call($method, $parameters = null)
    {
        if (! class_exists($class = $this->getClassNameFromMethod($method))) {
            throw new Exception("Method {$this->getClassNameFromMethod($method)} does not exist");
        }

        $instance = new $class($this->options);

        // Delegate the handling of this method call to the appropriate class
        return call_user_func_array([$instance, 'execute'], $parameters);
    }

    /**
     * Get class name that handles execution of this method
     *
     * @param $method
     * @return string
     */
    private function getClassNameFromMethod($method)
    {
        return 'App\Services\Opticomm\Methods\\' . ucwords($method);
    }
}
