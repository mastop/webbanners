<?php

namespace Banner\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BannerUserBundle:Default:index.html.twig');
    }
}
