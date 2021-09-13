<?php

namespace AEcalle\Oc\Php\Project5\Entity;

use Assert\Assertion;

class User 
{
    private int $id;
    private string $email;
    private string $password;
    private \DateTime $created_at;    

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

        Assertion::email($email, "Le format de l'adresse email est incorrecte.");
        Assertion::notEmpty($email,"Le champ email doit être renseigné.");

        return $this;
    }
 
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        Assertion::notEmpty($password,"Le champ password doit être renseigné.");

        return $this;
    }
   
    public function getCreated_at(): \DateTime
    {
        return $this->created_at;
    }

    public function setCreated_at(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}