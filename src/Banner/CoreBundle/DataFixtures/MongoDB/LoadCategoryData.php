<?php
namespace Banner\CoreBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Banner\CoreBundle\Document\Category;

class LoadCategoryData implements FixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $categorias = array('Bares & Restaurantes', 'Beleza & Saúde', 'Lazer', 'Serviços', 'Outros');
        foreach ($categorias as $cat) {
            $Category = new Category();
            $Category->setName($cat);
            if($cat == 'Outros') $Category->setOrder(1);
            $manager->persist($Category);
        }
        $manager->flush();
    }
}