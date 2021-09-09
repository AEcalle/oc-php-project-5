<?php

namespace AEcalle\Oc\Php\Project5\Repository;

use AEcalle\Oc\Php\Project5\Entity\Comment;
use AEcalle\Oc\Php\Project5\Repository\AbstractRepository;

class CommentRepository extends AbstractRepository
{
    protected string $table = 'comment';

    public function add(Comment $comment): Comment 
    {
        $q = parent::$db->prepare("INSERT INTO $this->table(content, created_at, writer, post_id) 
        VALUES(:content, :created_at, :writer, :post_id)");
        $q->execute([           
            ':content' => $comment->getContent(),
            ':created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
            ':writer' => $comment->getWriter(),
            ':post_id' => $comment->getPostId()
        ]);

        $entity = $this->find(parent::$db->lastInsertId());

        return $entity;
    }

    public function update(int $id, string $content, string $createdAt, string $writer, int $postId): Comment 
    {
        $q = parent::$db->prepare("UPDATE $this->table SET content = :content, created_at = :created_at,
        writer = :writer, post_id = :post_id WHERE id = :id");
        $q->execute([
            ':id' => $id,      
            ':content' => $content,
            ':created_at' => $createdAt,
            ':writer' => $writer,
            ':post_id' => $postId
        ]);

        $entity = $this->find($id);

        return $entity;
    }
}
