<?php

namespace AEcalle\Oc\Php\Project5\Repository;

use AEcalle\Oc\Php\Project5\Entity\Post;
use AEcalle\Oc\Php\Project5\Repository\AbstractRepository;

class PostRepository extends AbstractRepository
{
    protected string $table = 'post';

    public function add(string $title, string $standfirst, string $content, string $createdAt, string $updatedAt, 
    string $userId): Post {
        $q = parent::$db->prepare("INSERT INTO $this->table(title,standfirst,content,created_at,updated_at,user_id) 
        VALUES(:title,:standfirst,:content,:created_at,:updated_at,:user_id)");
        $q->execute([
            ':title' => $title,
            ':standfirst' => $standfirst,
            ':content' => $content,
            ':created_at' => $createdAt,
            ':updated_at' => $updatedAt,
            ':user_id' => $userId
        ]);

        $entity = $this->find(parent::$db->lastInsertId());

        return $entity;
    }

    public function update(int $id, string $title, string $standfirst, string $content, string $createdAt, string $updatedAt,
        string $userId): Post {
        $q = parent::$db->prepare("UPDATE $this->table SET title = :title, standfirst = :standfirst, 
        content = :content, created_at = :created_at,updated_at = :updated_at,user_id = :user_id WHERE id = :id");
        $q->execute([
            ':id' => $id,
            ':title' => $title,
            ':standfirst' => $standfirst,
            ':content' => $content,
            ':created_at' => $createdAt,
            ':updated_at' => $updatedAt,
            ':user_id' => $userId
        ]);

        $entity = $this->find($id);

        return $entity;
    }
}
