<?php

namespace Banner\CoreBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Banner\CoreBundle\Document\Banner;

class LoadBannerData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $path = $this->container->get('kernel')->getRootDir() . "/../web/uploads/bannercore/banner";
        for($i = 1; $i <= 6; $i++){
            $banner = new Banner();
            $banner->setTitle('Banner '.$i);
            $banner->setUrl('http://banner.dev.cc/#'.$i);
            $banner->setNewWindow(false);
            $banner->setOrder($i);
            $banner->setActive(true);
            $banner->setFilename('slide-'.$i.'.png');
            $banner->setFilesize(filesize($path.'/slide-'.$i.'.png'));
            $banner->setPath($path);
            $manager->persist($banner);
            $manager->flush();
        }
    }
    public function getOrder()
    {
        return 3;
    }
}