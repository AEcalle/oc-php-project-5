<?php

namespace AEcalle\Oc\Php\Project5\Entity;

use Assert\Assertion;

class Comment
{
    private int $id;
    private string $content;
    private \DateTime $createdAt;
    private string $writer;
    private bool $published;
    private int $postId;
 
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        Assertion::notEmpty($content,"Le champ commentaire doit être renseigné.");

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
     
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getWriter(): string
    {
        return $this->writer;
    }

    public function setWriter(string $writer): self
    {
        $this->writer = $writer;

        Assertion::notEmpty($writer,"Le champ utilisateur doit être renseigné.");

        return $this;
    }

    public function getPublished(): bool
    {
        return $this->published;
    }
    
    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }
 
    public function getPostId()
    {
        return $this->postId;
    }
 
    public function setPostId(int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

    
}