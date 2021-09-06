<?php 
namespace AEcalle\Oc\Php\Project5\Service;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

final class MailerService
{  
    public static function sendEmail(string $from,string $name,string $message): void
    {
        $transport = Transport::fromDsn("smtp://{$_ENV['SMTP_HOST']}?encryption=ssl&auth_mode=login&username={$_ENV['SMTP_USERNAME']}&password={$_ENV['SMTP_PASSWORD']}");
        $mailer = new Mailer($transport);    

        $email = (new Email())
            ->from($from)
            ->to('contact@aurelienecalle.fr')       
            ->subject('Mail envoyé depuis le blog')
            ->text("Message de : $name. $message")
            ->html("<p>Message de : $name.<p></p> $message</p>");
    
        // $mailer->send($email);       
    }
}