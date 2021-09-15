<?php

namespace AEcalle\Oc\Php\Project5\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

final class TokenCSRFManager
{
    public function createToken(string $name): string
    {
        $session = new Session();
       
        if ($session->get($name.'_token')===null)
        {           
            $token = uniqid(rand(), true);
            $session->set($name.'_token', $token);                       
        }
        else
        {
            $token = $session->get($name.'_token');
        }
        
        return $token;
    }

    public function verifToken(string $name, Request $request): bool
    {
        $session = new Session();
    
        if ($session->get($name.'_token') !== null && $request->request->get($name.'_token') !== null){            
            if ($session->get($name.'_token') === $request->request->get($name.'_token')){                      
                if (preg_match('#'.$_ENV["URL_SITE"].'#', $request->server->get('HTTP_REFERER'))){                    
                    return true;
                }
            }
        }
        return false;
    }
}