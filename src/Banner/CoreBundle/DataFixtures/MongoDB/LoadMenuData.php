<?php

namespace Banner\CoreBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Mastop\MenuBundle\Document\Menu;
use Mastop\MenuBundle\Document\MenuItem;

class LoadMenuData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $repo = $manager->getRepository('MastopMenuBundle:Menu');
        // Pega menu Pai System-Admin
        $menu = $repo->findByBundleCode('system', 'admin');
        if ($menu) {
            $menuItem1 = $repo->getChildrenByCode($menu, 'email');
            if(!$menuItem1){
                $child = new MenuItem();
                $child->setCode('email');
                $child->setName('E-mails');
                $child->setRole('ROLE_ADMIN');
                $child->setUrl('admin_core_mailing_index');
                $child->setRoute(true);
                $child->setOrder(3);
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush(); 
            }
            $menuItem2= $repo->getChildrenByCode($menu, 'discount');
            if(!$menuItem2){
                $child = new MenuItem();
                $child->setCode('ofertas');
                $child->setName('Discount');
                $child->setRole('ROLE_ADMIN');
                $child->setUrl('admin_order_discount');
                $child->setRoute(true);
                $child->setOrder(4);
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush(); 
            }
            $menuItem3 = $repo->getChildrenByCode($menu, 'status');
            if(!$menuItem3){
                $child = new MenuItem();
                $child->setCode('category');
                $child->setName('Status');
                $child->setRole('ROLE_ADMIN');
                $child->setUrl('admin_order_status');
                $child->setRoute(true);
                $child->setOrder(5);
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush(); 
            }
            $menuItem4 = $repo->getChildrenByCode($menu, 'size');
            if(!$menuItem4){
                $child = new MenuItem();
                $child->setCode('cupons');
                $child->setName('Tamanhos');
                $child->setRole('ROLE_ADMIN');
                $child->setUrl('admin_order_size');
                $child->setRoute(true);
                $child->setOrder(6);
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush(); 
            }
            $menuItem5 = $repo->getChildrenByCode($menu, 'content');
            if(!$menuItem5){
                $child = new MenuItem();
                $child->setCode('content');
                $child->setName('Páginas');
                $child->setRole('ROLE_ADMIN');
                $child->setUrl('admin_core_content_index');
                $child->setRoute(true);
                $child->setOrder(7);
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                
                $child2 = new MenuItem();
                $child2->setCode('content.novo');
                $child2->setName('Adicionar');
                $child2->setRole('ROLE_ADMIN');
                $child2->setUrl('admin_core_content_form');
                $child2->setRoute(true);
                $child->addChildren($child2);
                $manager->persist($menu);
                $manager->flush();
            }
        }
        // Pega menu Pai System-Foot
        $menu = $repo->findByBundleCode('system', 'foot');
        if ($menu) {
            // Pega menu filho "Empresa" dentro do Foot
            $menuItem = $repo->getChildrenByCode($menu, 'empresa');
            if (!$menuItem) { // Só adiciona o novo menu se ele já não existir
                $child = new MenuItem();
                $child->setCode('empresa');
                $child->setName('Empresa');
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                    $child2 = new MenuItem();
                    $child2->setCode('empresa.sobre');
                    $child2->setName('Sobre');
                    $child2->setUrl('/pg/sobre-o-banner');
                $child->addChildren($child2);
                $manager->persist($menu);
                $manager->flush();
                    $child2 = new MenuItem();
                    $child2->setCode('empresa.contato');
                    $child2->setName('Contato');
                    $child2->setUrl('/fale-conosco');
                    $child2->setOrder(1);
                $child->addChildren($child2);
                $manager->persist($menu);
                $manager->flush();
                    $child2 = new MenuItem();
                    $child2->setCode('empresa.privacidade');
                    $child2->setName('Privacidade');
                    $child2->setUrl('/pg/privacidade');
                    $child2->setOrder(2);
                $child->addChildren($child2);
                $manager->persist($menu);
                $manager->flush();
                    $child2 = new MenuItem();
                    $child2->setCode('empresa.termos-e-condicoes');
                    $child2->setName('Termos e Condições');
                    $child2->setUrl('/pg/termos-e-condicoes');
                    $child2->setOrder(3);
                $child->addChildren($child2);
                $manager->persist($menu);
                $manager->flush();
            }
            $menuItem2 = $repo->getChildrenByCode($menu, 'saiba-mais');
            if(!$menuItem2){
                $child = new MenuItem();
                $child->setCode('saiba-mais');
                $child->setName('Saiba Mais');
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child2 = new MenuItem();
                $child2->setCode('saiba-mais.faq');
                $child2->setName('FAQ');
                $child2->setUrl('_faq');
                $child2->setRoute(true);
                $child->addChildren($child2);
                $manager->persist($menu);
                $manager->flush();
                $child2 = new MenuItem();
                $child2->setCode('saiba-mais.como-comprar');
                $child2->setName('Como Comprar');
                $child2->setUrl('/pg/como-comprar');
                $child2->setOrder(1);
                $child->addChildren($child2);
                $manager->persist($menu);
                $manager->flush();
            }
            $menuItem3 = $repo->getChildrenByCode($menu, 'pacotes');
            if(!$menuItem3){
                $child = new MenuItem();
                $child->setCode('pacotes');
                $child->setName('Pacotes');
                $menu->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child3 = new MenuItem();
                $child3->setCode('pacotes.free1');
                $child3->setName('Free1');
                $child3->setUrl('/pacotes/1');
                $child->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child3 = new MenuItem();
                $child3->setCode('pacotes.free1');
                $child3->setName('Free 1');
                $child3->setUrl('/pacotes/1');
                $child->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child3 = new MenuItem();
                $child3->setCode('pacotes.free2');
                $child3->setName('Free 2');
                $child3->setUrl('/pacotes/2');
                $child->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child3 = new MenuItem();
                $child3->setCode('pacotes.free3');
                $child3->setName('Free 3');
                $child3->setUrl('/pacotes/3');
                $child->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child3 = new MenuItem();
                $child3->setCode('pacotes.free4');
                $child3->setName('Free 4');
                $child3->setUrl('/pacotes/4');
                $child->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child3 = new MenuItem();
                $child3->setCode('pacotes.free5');
                $child3->setName('Free 5');
                $child3->setUrl('/pacotes/5');
                $child->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
                $child3 = new MenuItem();
                $child3->setCode('pacotes.free6');
                $child3->setName('Free 6');
                $child3->setUrl('/pacotes/6');
                $child->addChildren($child);
                $manager->persist($menu);
                $manager->flush();
            }
        }
    }

    public function getOrder() {
        return 2;
    }

}
