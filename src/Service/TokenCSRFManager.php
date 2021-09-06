<?php

namespace AEcalle\Oc\Php\Project5\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class TokenCSRFManager
{
    public function createToken(string $name=''): string
    {
        $session = new Session();
       
        if ($session->get($name.'_token')===null)
        {           
            $token = uniqid(rand(), true);
            $session->set($name.'_token',$token);
            $session->set($name.'_token_time',time());            
        }
        else
        {
            $token = $session->get($name.'_token');
        }
        
        return $token;
    }

    public function verifToken(string $name = ''): bool
    {
        $session = new Session();
        $request = Request::createFromGlobals();
        if ($session->get($name.'_token')!==null && $session->get($name.'_token_time')!==null && $request->request->get($name.'_token')!==null)            
            if ($session->get($name.'_token')==$request->request->get($name.'_token'))                
               if ($request->getUri()==$request->server->get('HTTP_REFERER'))
                    return true;
        return false;
    }
}