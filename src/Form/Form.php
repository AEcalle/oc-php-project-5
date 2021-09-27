<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Form;

use AEcalle\Oc\Php\Project5\Service\TokenCSRFManager;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\Request;

final class Form
{
    private string $name;
    private ?Request $request = null;
    private object $entity;
    private object $tokenCSRFManager;
    private string $token;
    /**
     * @var array<string>
     */
    private array $constraintViolation = [];

    public function __construct(object $entity, string $name)
    {
        $this->entity = $entity;
        $this->name = $name;
        $this->tokenCSRFManager = new TokenCSRFManager();
        $this->token = $this->tokenCSRFManager->createToken($name);
    }

    public function handleRequest(Request $request): self
    {
        $this->request = $request;
        $data = $request->request->all();

        foreach ($data as $k => $v) {
            $method = 'set';
            $method .= ucfirst($k);
            try {
                if (is_callable([$this->entity, $method])) {
                    $this->entity->$method($v);
                }
            } catch (AssertionFailedException $e) {
                $this->constraintViolation[] = $e->getMessage();
            }
        }
        return $this;
    }

    public function isSubmitted(): bool
    {
        if ($this->request->getMethod() === 'POST') {
            return true;
        }
        return false;
    }

    public function isValid(): bool
    {
        if (count($this->constraintViolation) > 0) {
            return false;
        }
        return $this->tokenCSRFManager->verifToken($this->name, $this->request);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<string>
     */

    public function getConstraintViolation(): array
    {
        return $this->constraintViolation;
    }

    public function getEntity(): object
    {
        return $this->entity;
    }
}
