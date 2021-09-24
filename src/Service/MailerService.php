<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Service;

use AEcalle\Oc\Php\Project5\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

final class MailerService
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sendEmail(Contact $contact): void
    {
        $host = $this->request->server->get('SMTP_HOST');
        $userName = $this->request->server->get('SMTP_USERNAME');
        $password = $this->request->server->get('SMTP_PASSWORD');

        $transport = Transport::fromDsn(
            "smtp://{$host}?encryption=ssl&auth_mode=login&username={$userName}&password={$password}"
        );

        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from($contact->getEmail())
            ->to('contact@aurelienecalle.fr')
            ->subject('Mail envoyé depuis le blog')
            ->text(
                "Message de : {$contact->getName()}. {$contact->getMessage()}"
            )
            ->html(
                "<p>Message de : {$contact->getName()}.<p>
                </p> {$contact->getMessage()}</p>"
            );

        $mailer->send($email);
    }
}
