<?php

namespace AEcalle\Oc\Php\Project5\Service;

use Assert\Assertion;
use Assert\AssertionFailedException;

class ValidatorService
{
    public function isEmailCorrect(string $email): array
    {
        try {
            Assertion::email($email, "L'adresse email est incorrecte.");
        } catch(AssertionFailedException $e) {  
        }            
        if (isset($e))
        {
            return ['test'=>false,'message'=>$e->getMessage()];
        }
        return ['test'=>true];
    }
}