<?php

namespace Banner\OrderBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Banner\OrderBundle\Document\Status;

class LoadStatusData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    } 

    public function load(ObjectManager $manager) {
        $status = new Status();
        $status->setName('Em análise');
        $status->setOrder(1);
        $manager->persist($status);
        $manager->flush();
        
        $status = new Status();
        $status->setName('Aguardando Design');
        $status->setOrder(2);
        $manager->persist($status);
        $manager->flush();
        
        $status = new Status();
        $status->setName('Aguardando Cliente');
        $status->setOrder(3);
        $manager->persist($status);
        $manager->flush();
        
        $status = new Status();
        $status->setName('Finalizado');
        $status->setOrder(4);
        $manager->persist($status);
        $manager->flush();
    }
    
    public function getOrder() {
        return 1;
    }

}
