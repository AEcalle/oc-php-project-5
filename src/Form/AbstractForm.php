<?php

namespace AEcalle\Oc\Php\Project5\Form;

use Symfony\Component\HttpFoundation\Request;
use AEcalle\Oc\Php\Project5\Service\ValidatorService;

abstract class AbstractForm 
{    
    protected static Request $request;    
    protected string $token;     

    public function __construct()
    {
        self::$request = Request::createFromGlobals();
        $this->token = ValidatorService::createToken('contact'); 
    }
    
    public function isSubmitted(): bool
    {        
        if (self::$request->getMethod() === 'POST')
            return true;
        return false;
    }

    public function handleRequest()
    {         
        $data = self::$request->request->all();  
        unset($data['contact_token']);
        
        foreach ($data as $k=>$v)
        {
            $method = 'set';
            $method .= ucfirst($k);
            $this->$method($v);            
        }

        return $this;
    }
}