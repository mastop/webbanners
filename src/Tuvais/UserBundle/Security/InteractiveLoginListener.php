<?php

namespace Tuvais\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Tuvais\UserBundle\Security\Document\UserProvider;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class InteractiveLoginListener
{
    protected $userManager;

    public function __construct(UserProviderInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if ($user instanceof UserInterface && $user->getUsername() != 'admin' && $user->getUsername() != 'mastop') {
            $user->setLastlogin(new \DateTime());
            $this->userManager->updateUser($user);
        }
    }
}