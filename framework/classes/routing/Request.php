<?php

class Request
{
    public $requestObject;

    public function __construct(string $controllerName)
    {
        global $PARAMS;
        $this->requestObject = $PARAMS[$controllerName];
    }
}
