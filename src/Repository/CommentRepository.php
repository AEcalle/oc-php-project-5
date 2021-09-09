<?php

namespace AEcalle\Oc\Php\Project5\Repository;

use AEcalle\Oc\Php\Project5\Entity\Comment;
use AEcalle\Oc\Php\Project5\Repository\AbstractRepository;

class CommentRepository extends AbstractRepository
{
    protected string $table = 'comment';

    public function add(Comment $comment): Comment 
    {
        $q = parent::$db->prepare("INSERT INTO $this->table(content, created_at, writer, published, post_id) 
        VALUES(:content, :created_at, :writer, :published, :post_id)");
        $q->execute([           
            ':content' => $comment->getContent(),
            ':created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
            ':writer' => $comment->getWriter(),
            ':published' => $comment->getPublished(),
            ':post_id' => $comment->getPostId()
        ]);

        $entity = $this->find(parent::$db->lastInsertId());

        return $entity;
    }

    public function update(Comment $comment): Comment 
    {
        $q = parent::$db->prepare("UPDATE $this->table SET content = :content, created_at = :created_at,
        writer = :writer, published = :published, post_id = :post_id WHERE id = :id");
        $q->execute([
            ':id' => $comment->getId(),      
            ':content' => $comment->getContent(),
            ':created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
            ':writer' => $comment->getWriter(),
            ':published' => $comment->getPublished(),
            ':post_id' => $comment->getPostId()
        ]);

        $entity = $this->find($comment->getId());

        return $entity;
    }
}
