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
            self::$db = new \PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
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

    public function find(int $id): object
    {
        $q = self::$db->prepare("SELECT * FROM  {$this->table} WHERE id = :id");
        $q->execute([
            ':id' => $id
        ]);        

        return $this->createEntity($q->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @return Object[]
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
     * @return object[]
     */

    public function findBy(array $criteria, array $orderBy, int $offset, int $nbRows): array
    {
        $parameters = [];

        $whereClause = "";
        
        if ($criteria)
        {
            $whereClause = "WHERE ";
            foreach($criteria as $k=>$v)
            {                
                $whereClause .= "$k = :$k";               
                
                if ($k !== array_key_last($criteria)) 
                {
                    $whereClause .= " AND ";
                }
                $k = ":$k";
                $parameters[$k] = $v;
            }
        } 
        
        $orderClause = "";
        if ($orderBy)
        {
            $orderClause = "ORDER BY ";
            foreach ($orderBy as $k=>$v)
            {
                $orderClause .= "$k $v";
                if ($k !== array_key_last($orderBy)) 
                {
                    $orderClause .= ", ";
                }            
            }
        }       
        
        $q = self::$db->prepare("SELECT * FROM {$this->table} $whereClause $orderClause LIMIT :offset,:nbRows");
        $q->bindValue(':offset', $offset, \PDO::PARAM_INT);  
        $q->bindValue(':nbRows', $nbRows, \PDO::PARAM_INT);
        foreach($parameters as $k=>$v)
        {          
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
        
        if (! $entities)
        {
            return null;
        }

        return $entities[0];
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
            if (preg_match('#^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$#', $v)) {
                $v = \DateTime::createFromFormat('Y-m-d H:i:s', $v);
            }
            $entity->$method($v);
        }
        return $entity;
    }

    public function delete($id): void
    {        
        $q = self::$db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $q->execute([
            ':id' => $id
        ]);
    }

    public function count(): int
    {
        $q = self::$db->prepare("SELECT COUNT(id) FROM {$this->table}");
        $q->execute();        
        $data = $q->fetch(\PDO::FETCH_ASSOC);

        return intval($data['COUNT(id)']);
    }
}
