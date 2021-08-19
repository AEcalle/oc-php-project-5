<?php

namespace AEcalle\Oc\Php\Project5;

class Route
{
    private $path;
    private $callable;
    
    public function __construct($path,$callable)
    {
        $this->path = $path;
        $this->callable = $callable;
    }
}