<?php

namespace Banner\OrderBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Banner\OrderBundle\Document\Size;

class LoadSizeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    } 

    
    public function load(ObjectManager $manager) {
        $size = new Size();
        $size->setWidth(728);
        $size->setHeight(90);
        $size->setOrder(1);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(468);
        $size->setHeight(60);
        $size->setOrder(2);
        $manager->persist($size);
        $manager->flush();
                
        $size = new Size();
        $size->setWidth(125);
        $size->setHeight(125);
        $size->setOrder(3);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(234);
        $size->setHeight(60);
        $size->setOrder(4);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(120);
        $size->setHeight(600);
        $size->setOrder(5);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(160);
        $size->setHeight(600);
        $size->setOrder(6);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(180);
        $size->setHeight(150);
        $size->setOrder(7);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(120);
        $size->setHeight(240);
        $size->setOrder(8);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(200);
        $size->setHeight(200);
        $size->setOrder(9);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(250);
        $size->setHeight(250);
        $size->setOrder(10);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(300);
        $size->setHeight(250);
        $size->setOrder(11);
        $manager->persist($size);
        $manager->flush();
        
        $size = new Size();
        $size->setWidth(336);
        $size->setHeight(280);
        $size->setOrder(12);
        $manager->persist($size);
        $manager->flush();
    }
    
    public function getOrder() {
        return 1;
    }

}
