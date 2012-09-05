<?php

namespace Banner\OrderBundle\Controller\Backend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Banner\OrderBundle\Document\Size;
use Banner\OrderBundle\Form\Backend\SizeType;

class SizeController extends BaseController
{ 
    /**
     * @Route("/", name="admin_order_size")
     * @Template()
     */
    public function sizeAction()
    {
        
        $allsize = $this->mongo('BannerOrderBundle:Size')->findAllByOrder();
                
        return array(
                        'allsize'   => $allsize, 
                    );
     }   
      
    /**
     * @Route("/form/{id}", name="admin_order_size_form", defaults={"id" = null})
     * @Template()
    */
    public function formAction(Size $size = null)
    {
        $dm = $this->dm();
        $title = ($size) ? "Editar Size" : "Novo Size";
        $msg = ($size) ? "Size Alterado" : "Size Criado";
        if(!$size){
            $size = new Size();
        }
        $form = $this->createForm(new SizeType(), $size);
        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $dm->persist($size);
                $dm->flush();
                return $this->redirectFlash($this->generateUrl('admin_order_size'), $msg);
            }
        }
        return array('form' => $form->createView(), 'size' => $size, 'title'=>$title, 'current' => 'admin_order_size');
    }
   
     /**
     * @Route("/delete-{id}", name="admin_order_size_delete")
     * @Template()
     */
    public function deleteAction(Size $size)
    {
        if($this->get('request')->getMethod() == 'POST'){
            $this->dm()->remove($size);
            $this->dm()->flush();
            return $this->redirectFlash($this->generateUrl('admin_order_size_index'), 'Size Deletada!');
        }
        return $this->confirm('Tem certeza de que deseja remover o Size "' . $size->getName() . '"?', array('id' => $size->getId()));
    }
}