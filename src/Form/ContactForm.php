<?php

namespace AEcalle\Oc\Php\Project5\Form;

class ContactForm extends AbstractForm 
{
    protected string $token;
    private string $name = '';
    private string $email = '';
    private string $message = '';
    private string $flashMessage = ''; 
    private string $colorFlashMessage = 'danger';    

    public function getToken(): string
    {
        return $this->token;
    } 
    
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
   
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
   
    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    } 

    public function getFlashMessage(): string
    {
        return $this->flashMessage;
    }

    public function setFlashMessage(string $flashMessage): self
    {
        $this->flashMessage = $flashMessage;

        return $this;
    }
    
    public function getColorFlashMessage(): string
    {
        return $this->colorFlashMessage;
    }
   
    public function setColorFlashMessage(string $colorFlashMessage): self
    {
        $this->colorFlashMessage = $colorFlashMessage;

        return $this;
    }
}