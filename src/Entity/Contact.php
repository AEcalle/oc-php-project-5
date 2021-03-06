<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Entity;

use Assert\Assertion;

final class Contact
{
    private string $name = '';
    private string $email = '';
    private string $message = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $assertion = new Assertion();
        $assertion->notEmpty(
            $name,
            'Le champ nom doit être renseigné.'
        );

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
        $assertion->notEmpty(
            $email,
            'Le champ email doit être renseigné.'
        );
        $assertion->email(
            $email,
            'Le format de l\'adresse email est incorrecte.'
        );

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        $assertion = new Assertion();
        $assertion->notEmpty(
            $message,
            'Le champ message doit être renseigné.'
        );

        return $this;
    }
}
