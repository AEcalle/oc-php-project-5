<?php

namespace AEcalle\Oc\Php\Project5\Repository;

use AEcalle\Oc\Php\Project5\Entity\Post;

final class PostRepository extends AbstractRepository
{
    protected string $table = 'post';

    public function add(Post $post): Post 
    {
        $q = parent::$db->prepare("INSERT INTO {$this->table}(title,standfirst,content,created_at,updated_at,user_id) 
        VALUES(:title,:standfirst,:content,:created_at,:updated_at,:user_id)");
        $q->execute([
            ':title' => $post->geTtitle(),
            ':standfirst' => $post->getStandfirst(),
            ':content' => $post->getContent(),
            ':created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $post->getUpdatedAt()->format('Y-m-d H:i:s'),
            ':user_id' => $post->getUserId(),
        ]);      

        return $this->find(parent::$db->lastInsertId());
    }

    public function update(Post $post): Post 
    {
        $q = parent::$db->prepare("UPDATE {$this->table} SET title = :title, standfirst = :standfirst, 
        content = :content, created_at = :created_at,updated_at = :updated_at,user_id = :user_id WHERE id = :id");
        $q->execute([
            ':id' => $post->getId(),
            ':title' => $post->geTtitle(),
            ':standfirst' => $post->getStandfirst(),
            ':content' => $post->getContent(),
            ':created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $post->getUpdatedAt()->format('Y-m-d H:i:s'),
            ':user_id' => $post->getUserId(),
        ]);        

        return $this->find($post->getId());
    }
}
