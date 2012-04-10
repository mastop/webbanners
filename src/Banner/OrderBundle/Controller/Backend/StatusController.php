<?php

namespace Banner\OrderBundle\Controller\Backend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Banner\OrderBundle\Document\Status;
use Banner\OrderBundle\Form\Backend\StatusType;

class StatusController extends BaseController
{ 
    /**
     * @Route("/", name="admin_order_status")
     * @Template()
     */
    public function statusAction()
    {
        
        $allstatus = $this->mongo('BannerOrderBundle:Status')->findAllByOrder();
                
        return array(
                        'allstatus'   => $allstatus, 
                    );
     }   
      
    /**
     * @Route("/form/{id}", name="admin_order_status_form", defaults={"id" = null})
     * @Template()
    */
    public function formAction(Status $status = null)
    {
        $dm = $this->dm();
        $title = ($status) ? "Editar Status" : "Novo Status";
        $msg = ($status) ? "Status Alterado" : "Status Criado";
        if(!$status){
            $status = new Status();
        }
        $form = $this->createForm(new StatusType(), $status);
        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $dm->persist($status);
                $dm->flush();
                return $this->redirectFlash($this->generateUrl('admin_order_status'), $msg);
            }
        }
        return array('form' => $form->createView(), 'status' => $status, 'title'=>$title, 'current' => 'admin_order_status');
    }
   
     /**
     * @Route("/delete-{id}", name="admin_order_status_delete")
     * @Template()
     */
    public function deleteAction(Status $status)
    {
        if($this->get('request')->getMethod() == 'POST'){
            $this->dm()->remove($status);
            $this->dm()->flush();
            return $this->redirectFlash($this->generateUrl('admin_order_status_index'), 'Status Deletada!');
        }
        return $this->confirm('Tem certeza de que deseja remover o Status "' . $status->getName() . '"?', array('id' => $status->getId()));
    }
}