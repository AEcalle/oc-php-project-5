<?php

namespace AEcalle\Oc\Php\Project5\Form;

use Symfony\Component\HttpFoundation\Request;
use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;

abstract class AbstractForm 
{  
    private ?Request $request = null;
    protected string $token;     

    public function __construct()
    {    
        $tokenCSRFManager = new TokenCSRFManager();
        $this->token = $tokenCSRFManager->createToken('contact'); 
    }  

    public function handleRequest(Request $request)
    {         
        $this->request = $request;

        $data = $request->request->all();  
        unset($data['contact_token']);
        
        foreach ($data as $k=>$v)
        {
            $method = 'set';
            $method .= ucfirst($k);
            $this->$method($v);            
        }

        return $this;
    }

    public function isSubmitted(): bool
    {        
        if ($this->request->getMethod() === 'POST')
            return true;
        return false;
    }
}