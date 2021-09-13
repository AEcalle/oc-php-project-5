<?php

namespace AEcalle\Oc\Php\Project5\Repository;

use AEcalle\Oc\Php\Project5\Entity\User;
use AEcalle\Oc\Php\Project5\Repository\AbstractRepository;

class UserRepository extends AbstractRepository
{
    protected string $table = 'user';

    public function add(User $user): User 
    {
        $q = parent::$db->prepare("INSERT INTO $this->table(email,password,created_at) 
        VALUES(:email,:password,:created_at)");
        $q->execute([           
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s')      
        ]);

        $entity = $this->find(parent::$db->lastInsertId());

        return $entity;
    }

    public function update(User $user): User 
    {
        $q = parent::$db->prepare("UPDATE $this->table SET email = :email, password = :password, created_at = :created_at WHERE id = :id");
        $q->execute([
            ':id' => $user->getId(),      
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);

        $entity = $this->find($user->getId());

        return $entity;
    }
}

