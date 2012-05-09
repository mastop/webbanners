<?php

namespace Banner\UserBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Banner\UserBundle\Document\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    } 

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setName('Suporte Mastop');
        $user->setEmail('suporte@mastop.com.br');
        $user->setLang('pt_BR');
        $user->setCreated(new \DateTime());
        $user->setTheme('');
        $user->setStatus(1);
        $user->setRoles('ROLE_ADMIN');
        $user->setMailOk(true);
        $user->setUsername('suportemastopcombr');
        $user->setPassword("QRcrz4q1+CMeIOSJe9qybVEL5agAMeWRc1ZpPj/wDlH8lbgaJetnRvz79I0WuPwjIcuVsU/cuF733/Ts1KHd1A==");
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setName('Mastop');
        $user->setEmail('mastop@mastop.com.br');
        $user->setLang('pt_BR');
        $user->setCreated(new \DateTime());
        $user->setTheme('');
        $user->setStatus(1);
        $user->setRoles('ROLE_SUPERADMIN');
        $user->setMailOk(true);
        $user->setUsername('mastopmastopcombr');
        $user->setPassword("5wqjnkXHoGQ2ni1eOT8f83+uGjykKiVr35hfM90oSMX779xWoRxJQL6EYd8Mx4lV/bedVbWbQVhMBtMXoQC2JA==");
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setName('Leonardo');
        $user->setEmail('leonardo@mastop.com.br');
        $user->setLang('pt_BR');
        $user->setCreated(new \DateTime());
        $user->setTheme('');
        $user->setStatus(1);
        $user->setRoles('ROLE_DESIGNER');
        $user->setMailOk(true);
        $user->setUsername('leonardomastopcombr');
        $user->setPassword("2hvirKcZwr09YTgp20qB6XWVKweWsqYNJ8mJGablkllTE63+lIvPqukx9SENhoGTRh0PFJ386d4uhpMT\/3PUOw==");
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setName('Leonardo');
        $user->setEmail('leo@mastop.com.br');
        $user->setLang('pt_BR');
        $user->setCreated(new \DateTime());
        $user->setTheme('');
        $user->setStatus(1);
        $user->setRoles('ROLE_USER');
        $user->setMailOk(true);
        $user->setUsername('leomastopcombr');
        $user->setPassword("vNz7h1eO9IXxEynVJMLP4\/vFtzDwMlNUBFqL7HxazZZdNdfMjxNOeQqPJKsskoTa+taMKHnRMIh7uDH1qvOadQ==");
        $manager->persist($user);
        $manager->flush();
    }
    
    public function getOrder() {
        return 1;
    }

}
