<?php

namespace AEcalle\Oc\Php\Project5\Repository;

abstract class AbstractRepository
{
    protected static \PDO $db;
    protected string $table;
    private string $class;

    public function __construct()
    {
        try {
            self::$db = new \PDO('mysql:host=Blog;dbname=blog;charset=utf8', 'root', '');
            self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        $classNameExploded = explode('_', $this->table);
        $className = '';
        foreach ($classNameExploded as $word) {
            $className .= ucfirst($word);
        }
        $namespace = 'AEcalle\Oc\Php\Project5\Entity\\';
        $this->class = $namespace . $className;
    }

    public function find(int $id): Object
    {
        $q = self::$db->prepare("SELECT * FROM  $this->table WHERE id = :id");
        $q->execute([
            ':id' => $id
        ]);
        $entity = $this->createEntity($q->fetch(\PDO::FETCH_ASSOC));

        return $entity;
    }

    /**
     * @var Object[]
     */

    public function findAll(): array
    {
        $q = self::$db->prepare("SELECT * FROM $this->table");
        $q->execute();
        $entities = [];
        while ($data = $q->fetch(\PDO::FETCH_ASSOC)) {
            $entity = $this->createEntity($data);
            $entities[] = $entity;
        }


        return $entities;
    }

    /**
     * @var Object[]
     */

    public function findBy(int $offset, int $nbRows): array
    {
        $q = self::$db->prepare("SELECT * FROM $this->table ORDER BY id DESC LIMIT :offset,:nbRows");
        $q->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $q->bindValue(':nbRows', $nbRows, \PDO::PARAM_INT);
        $q->execute();
        $entities = [];
        while ($data = $q->fetch(\PDO::FETCH_ASSOC)) {
            $entity = $this->createEntity($data);
            $entities[] = $entity;
        }


        return $entities;
    }    

    protected function createEntity(array $data): Object
    {
        $entity = new $this->class();
        foreach ($data as $k => $v) {
            $methodExploded = explode('_', $k);
            $method = 'set';
            foreach ($methodExploded as $word) {
                $method .= ucfirst($word);
            }
            if (preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$#', $v)) {
                $v = \DateTime::createFromFormat('Y-m-d H:i:s', $v);
            }
            $entity->$method($v);
        }
        return $entity;
    }

    public function delete($id): void
    {
        $table = $this->table;
        $q = self::$db->prepare("DELETE FROM $table WHERE id = :id");
        $q->execute([
            ':id' => $id
        ]);
    }
}
