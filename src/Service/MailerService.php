<?php 
namespace AEcalle\Oc\Php\Project5\Service;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class MailerService
{  
    public function sendEmail(string $from,string $name,string $message): void
    {
        $transport = Transport::fromDsn('smtp://smtp.ionos.fr:465?encryption=ssl&auth_mode=login&username=&password=&verify_peer=false');
        $mailer = new Mailer($transport);    

        $email = (new Email())
            ->from($from)
            ->to('contact@aurelienecalle.fr')       
            ->subject('Mail envoyé depuis le blog')
            ->text("Message de : $name. $message")
            ->html("<p>Message de : $name.<p></p> $message</p>");
    
        $mailer->send($email);       
    }
}