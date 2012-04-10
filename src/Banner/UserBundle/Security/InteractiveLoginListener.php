<?php

namespace Banner\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Banner\UserBundle\Security\Document\UserProvider;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InteractiveLoginListener
{
    protected $userManager;
    protected $container;

    public function __construct(UserProviderInterface $userManager, ContainerInterface $container)
    {
        $this->userManager = $userManager;
        $this->container = $container;
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