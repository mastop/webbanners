<?php
namespace Banner\UserBundle\Controller\Frontend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Controller que será o DashBoard do usúario.
 */

class DashboardController extends BaseController
{
    /**
     * Index do Dasboard
     * 
     * @Route("minha-conta/", name="user_dashboard_index")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function indexAction(){
        $title = 'Minha Conta';
        $tabs = array(
            'mydata' => 'Meus Dados',
            //'myorders' => 'Minhas Compras',
            //'mysales' => 'Minhas Vendas',
            //'mybalance' => 'Meu Financeiro',
        );
        $panes = array(
            'mydata' => 'BannerUserBundle:Widget\\MyData:dashboard',
            //'BannerOrderBundle:Widget\\MyOrders:dashboard',
            //'BannerOrderBundle:Widget\\MySales:dashboard',
            //'BannerOrderBundle:Widget\\MyBalance:dashboard',
        );
        return array(
            'title' => $title,
            'tabs'  => $tabs,
            'panes' => $panes,
        );
    }
}