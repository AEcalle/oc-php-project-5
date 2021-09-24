<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Entity;

use Assert\Assertion;

final class User
{
    private int $id;
    private string $email;
    private string $password;
    private \DateTime $createdAt;
    private string $role;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        $assertion = new Assertion();
        $assertion->email(
            $email,
            'Le format de l\'adresse email est incorrecte.'
        );
        $assertion->notEmpty(
            $email,
            'Le champ email doit être renseigné.'
        );

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        $assertion = new Assertion();
        $assertion->notEmpty(
            $password,
            'Le champ password doit être renseigné.'
        );

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

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
