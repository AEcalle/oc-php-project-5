<?php

declare(strict_types=1);

namespace AEcalle\Oc\Php\Project5\Service;

use AEcalle\Oc\Php\Project5\Entity\User;
use AEcalle\Oc\Php\Project5\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;

final class Authentication
{
    public function checkUserSession(Session $session): bool
    {
        return null !== $session->get('userId');
    }

    public function checkUserInDb(
        User $user,
        UserRepository $userRepository,
        Session $session
    ): bool {
        $userInDb = $userRepository->findOneBy(['email' => $user->getEmail()]);

        if (null === $userInDb) {
            $session->getFlashBag()
                ->add('warning', 'Adresse email inconnue');
            return false;
        }

        $passwordVerify = password_verify(
            $user->getPassword(),
            $userInDb->getPassword()
        );

        if (! $passwordVerify) {
            $session->getFlashBag()
                ->add('warning', 'Mot de passe incorrect');
            return false;
        }

        $session->set('userId', $userInDb->getId());

        return true;
    }
}
