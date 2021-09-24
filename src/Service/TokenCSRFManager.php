<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

final class TokenCSRFManager
{
    public function createToken(string $name): string
    {
        $session = new Session();

        if ($session->get($name.'_token') === null) {
            $token = uniqid((string) rand(), true);
            $session->set($name.'_token', $token);
        } else {
            $token = $session->get($name.'_token');
        }

        return $token;
    }

    public function verifToken(string $name, Request $request): bool
    {
        $session = new Session();

        if (
            $session->get($name.'_token') !== null &&
            $request->request->get($name.'_token') !== null
            ) {
            if (
                $session->get($name.'_token') ===
                $request->request->get($name.'_token')
                ) {
                if (
                    preg_match(
                        '#'.$request->server->get('URL_SITE').'#',
                        $request->server->get('HTTP_REFERER')
                    )
                    ) {
                    return true;
                }
            }
        }
        return false;
    }
}
