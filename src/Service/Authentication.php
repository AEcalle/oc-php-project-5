<?php

namespace AEcalle\Oc\Php\Project5\Service;
use Symfony\Component\HttpFoundation\Session\Session;

class Authentication
{      
    public function check(Session $session): bool
    {        
        if (null === $session->get('userId'))
        {            
            return false;
        }

        return true;
    }    
}