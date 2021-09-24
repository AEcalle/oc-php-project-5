<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Repository;

use AEcalle\Oc\Php\Project5\Entity\User;

final class UserRepository extends AbstractRepository
{
    protected string $table = 'user';

    public function add(User $user): User
    {
        $user->setPassword(password_hash(
            $user->getpassword(),
            PASSWORD_DEFAULT
        ));

        $q = parent::$db->prepare("INSERT INTO {$this->table}
        (email,password,created_at,role) 
        VALUES(:email,:password,:created_at,:role)");
        $q->execute([
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ':role' => $user->getRole(),
        ]);

        return $this->find((int) parent::$db->lastInsertId());
    }

    public function update(User $user): User
    {
        $q = parent::$db->prepare("UPDATE {$this->table} 
        SET email = :email, password = :password, created_at = :created_at, 
        role = :role WHERE id = :id");
        $q->execute([
            ':id' => $user->getId(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ':role' => $user->getRole(),
        ]);

        return $this->find($user->getId());
    }
}
