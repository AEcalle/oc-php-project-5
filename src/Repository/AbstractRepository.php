<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Repository;

use AEcalle\Oc\Php\Project5\Service\PdoProvider;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRepository
{
    protected static \PDO $db;
    protected string $table;
    private string $class;

    public function __construct(Request $request)
    {
        $pdoProvider = new PdoProvider($request);
        self::$db = $pdoProvider->connect();

        $classNameExploded = explode('_', $this->table);
        $className = '';
        foreach ($classNameExploded as $word) {
            $className .= ucfirst($word);
        }
        $namespace = 'AEcalle\Oc\Php\Project5\Entity\\';
        $this->class = $namespace . $className;
    }

    public function find(int $id): object
    {
        $q = self::$db->prepare("SELECT * FROM  {$this->table} WHERE id = :id");
        $q->execute([
            ':id' => $id,
        ]);

        return $this->createEntity($q->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @return array<object>
     */

    public function findAll(): array
    {
        $q = self::$db->prepare("SELECT * FROM {$this->table}");
        $q->execute();
        $entities = [];
        while ($data = $q->fetch(\PDO::FETCH_ASSOC)) {
            $entity = $this->createEntity($data);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * @return array<object>
     */

    public function findBy(
        array $criteria,
        array $orderBy,
        int $offset,
        int $nbRows
    ): array {
        $parameters = [];

        $whereClause = '';

        if ($criteria) {
            $whereClause = 'WHERE ';
            foreach ($criteria as $k => $v) {
                $whereClause .= "${k} = :${k}";

                if ($k !== array_key_last($criteria)) {
                    $whereClause .= ' AND ';
                }
                $k = ":${k}";
                $parameters[$k] = $v;
            }
        }

        $orderClause = '';
        if ($orderBy) {
            $orderClause = 'ORDER BY ';
            foreach ($orderBy as $k => $v) {
                $orderClause .= "${k} ${v}";
                if ($k !== array_key_last($orderBy)) {
                    $orderClause .= ', ';
                }
            }
        }

        $q = self::$db->prepare(
            "SELECT * FROM {$this->table} {$whereClause} {$orderClause} 
            LIMIT :offset,:nbRows"
        );
        $q->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $q->bindValue(':nbRows', $nbRows, \PDO::PARAM_INT);
        foreach ($parameters as $k => $v) {
            $q->bindValue($k, $v);
        }
        $q->execute();

        $entities = [];
        while ($data = $q->fetch(\PDO::FETCH_ASSOC)) {
            $entity = $this->createEntity($data);
            $entities[] = $entity;
        }

        return $entities;
    }

    public function findOneBy(array $criteria): ?object
    {
        $entities = $this->findBy($criteria, [], 0, 1);

        if (! $entities) {
            return null;
        }

        return $entities[0];
    }

    public function delete($id): void
    {
        $q = self::$db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $q->execute([
            ':id' => $id,
        ]);
    }

    public function count(): int
    {
        $q = self::$db->prepare("SELECT COUNT(id) FROM {$this->table}");
        $q->execute();
        $data = $q->fetch(\PDO::FETCH_ASSOC);

        return (int) ($data['COUNT(id)']);
    }

    protected function createEntity(array $data): object
    {
        $entity = new $this->class();
        foreach ($data as $k => $v) {
            $methodExploded = explode('_', $k);
            $method = 'set';
            foreach ($methodExploded as $word) {
                $method .= ucfirst($word);
            }

            $reflexionMethod = new \ReflectionMethod($entity, $method);
            $parameters = $reflexionMethod->getParameters();
            $type = $parameters[0]->getType()->getName();

            if ($type === 'DateTime') {
                $v = \DateTime::createFromFormat('Y-m-d H:i:s', $v);
            }
            if ($type === 'int') {
                $v = (int) ($v);
            }
            if ($type === 'bool') {
                $v === '1' ? $v = true : $v = false;
            }

            $entity->$method($v);
        }
        return $entity;
    }
}
