<?php

namespace Banner\OrderBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Banner\OrderBundle\Document\Discount;

class LoadDiscountData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    } 

    public function load(ObjectManager $manager) {
        $discount = new Discount();
        $discount->setCode('PACK1');
        $discount->setDescription('Pacote1');
        $discount->setDiscount(80);
        $discount->setType('valor');
        $discount->setUses(0);
        $discount->setLimit(0);
        $manager->persist($discount);
        $manager->flush();

        $discount = new Discount();
        $discount->setCode('PACK2');
        $discount->setDescription('Pacote2');
        $discount->setDiscount(160);
        $discount->setType('valor');
        $discount->setUses(0);
        $discount->setLimit(0);
        $manager->persist($discount);
        $manager->flush();

        $discount = new Discount();
        $discount->setCode('PACK3');
        $discount->setDescription('Pacote3');
        $discount->setDiscount(240);
        $discount->setType('valor');
        $discount->setUses(0);
        $discount->setLimit(0);
        $manager->persist($discount);
        $manager->flush();
        
        $discount = new Discount();
        $discount->setCode('PACK4');
        $discount->setDescription('Pacote4');
        $discount->setDiscount(320);
        $discount->setType('valor');
        $discount->setUses(0);
        $discount->setLimit(0);
        $manager->persist($discount);
        $manager->flush();
        
        $discount = new Discount();
        $discount->setCode('PACK5');
        $discount->setDescription('Pacote5');
        $discount->setDiscount(400);
        $discount->setType('valor');
        $discount->setUses(0);
        $discount->setLimit(0);
        $manager->persist($discount);
        $manager->flush();
        
        $discount = new Discount();
        $discount->setCode('PACK6');
        $discount->setDescription('Pacote6');
        $discount->setDiscount(480);
        $discount->setType('valor');
        $discount->setUses(0);
        $discount->setLimit(0);
        $manager->persist($discount);
        $manager->flush();
    }
    
    public function getOrder() {
        return 1;
    }

}
