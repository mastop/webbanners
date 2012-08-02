<?php

namespace Banner\OrderBundle\Controller\Backend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Banner\OrderBundle\Document\Discount;
use Banner\OrderBundle\Form\Backend\DiscountType;

class DiscountController extends BaseController
{ 
    /**
     * @Route("/", name="admin_order_discount")
     * @Template()
     */
    public function discountAction()
    {
        
        $alldiscount = $this->mongo('BannerOrderBundle:Discount')->findAll();
                
        return array(
                        'alldiscount'   => $alldiscount, 
                    );
     }  
     
  
      
    /**
     * @Route("/form/{id}", name="admin_order_discount_form", defaults={"id" = null})
     * @Template()
    */
    public function formAction(Discount $discount = null)
    {
        $dm = $this->dm();
        $title = ($discount) ? "Editar Discount" : "Novo Discount";
        $msg = ($discount) ? "Discount Alterado" : "Discount Criado";
        if(!$discount){
            $discount = new Discount();
        }
        $form = $this->createForm(new DiscountType(), $discount);
        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $code = $this->mastop()->generateCode();
                while($this->mongo('BannerOrderBundle:Discount')->has('code', $code)){
                    $code = $this->mastop()->generateCode();
                }
                $discount->setCode($code);
                $dm->persist($discount);
                $dm->flush();
                return $this->redirectFlash($this->generateUrl('admin_order_discount'), $msg);
            }
        }
        return array('form' => $form->createView(), 'discount' => $discount, 'title'=>$title, 'current' => 'admin_order_discount');
    }
   
     /**
     * @Route("/delete-{id}", name="admin_order_discount_delete")
     * @Template()
     */
    public function deleteAction(Discount $discount)
    {
        if($this->get('request')->getMethod() == 'POST'){
            $this->dm()->remove($discount);
            $this->dm()->flush();
            return $this->redirectFlash($this->generateUrl('admin_order_discount_index'), 'Discount Deletada!');
        }
        return $this->confirm('Tem certeza de que deseja remover o Discount "' . $discount->getDescription() . '"?', array('id' => $discount->getId()));
    }
}