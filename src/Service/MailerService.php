<?php 
namespace AEcalle\Oc\Php\Project5\Service;

use AEcalle\Oc\Php\Project5\Entity\Contact;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

final class MailerService
{  
    public static function sendEmail(Contact $contact): void
    {
        $transport = Transport::fromDsn("smtp://{$_ENV['SMTP_HOST']}?encryption=ssl&auth_mode=login&username={$_ENV['SMTP_USERNAME']}&password={$_ENV['SMTP_PASSWORD']}");
        $mailer = new Mailer($transport);    

        $email = (new Email())
            ->from($contact->getEmail())
            ->to('contact@aurelienecalle.fr')       
            ->subject('Mail envoyé depuis le blog')
            ->text("Message de : {$contact->getName()}. {$contact->getMessage()}")
            ->html("<p>Message de : {$contact->getName()}.<p></p> {$contact->getMessage()}</p>");
    
        // $mailer->send($email);       
    }
}