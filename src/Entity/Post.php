<?php

namespace AEcalle\Oc\Php\Project5\Entity;

use Assert\Assertion;

final class Post
{
    private int $id;
    private string $title;
    private string $slug;
    private string $standfirst;
    private string $content;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    private string $author;
    private int $userId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        Assertion::notEmpty($title,"Le champ titre doit être renseigné.");

        return $this;
    }
    
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getStandfirst(): string
    {
        return $this->standfirst;
    }

    public function setStandfirst(string $standfirst): self
    {
        $this->standfirst = $standfirst;

        Assertion::notEmpty($standfirst,"Le champ chapô doit être renseigné.");

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        Assertion::notEmpty($content,"Le champ contenu doit être renseigné.");

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

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {

        $this->author = $author;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    } 

    
}
