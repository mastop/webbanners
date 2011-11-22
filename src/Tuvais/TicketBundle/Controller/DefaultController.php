<?php

namespace Tuvais\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TuvaisTicketBundle:Default:index.html.twig');
    }
}
