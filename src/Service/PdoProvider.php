<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Service;

use Symfony\Component\HttpFoundation\Request;

final class PdoProvider
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function connect(): \PDO
    {
        $name = $this->request->server->get('DB_NAME');
        $host = $this->request->server->get('DB_HOST');
        $userName = $this->request->server->get('DB_USERNAME');
        $password = $this->request->server->get('DB_PASSWORD');

        $pdo = new \PDO(
            "mysql:dbname={$name};host={$host};",
            $userName,
            $password
        );
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
