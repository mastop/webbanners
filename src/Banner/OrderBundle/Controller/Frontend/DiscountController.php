<?php

namespace Banner\OrderBundle\Controller\Frontend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Banner\OrderBundle\Document\Discount;
use Banner\OrderBundle\Form\Backend\DiscountType;

class DiscountController extends BaseController
{   
    /**
     * @Route("/check", name="order_discount_check")
     * @Template()
     */
    public function checkAction()
    {
        if ($this->get('request')->isXmlHttpRequest()) {
            if ($this->get('request')->getMethod() == 'POST') {
                $cupom = $this->get('request')->request->get('cupom');
                if (!empty($cupom)) {
                    $result = $this->mongo('BannerOrderBundle:Discount')->findOneByCode($cupom);
                    if (($result != '')) {
                        return new Response((float)$result->getDiscount());
                        $result->getDiscount();
                    } else {
                        return new Response(0);
                    }
                }
            }
        }
        return new Response($this->get('translator')->trans('Operação não permitida.'));
        
     }  
}
