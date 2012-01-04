<?php

namespace Tuvais\TicketBundle\Controller\Backend;

use Mastop\SystemBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Tuvais\UserBundle\Form\Backend\UserForm;
use Tuvais\UserBundle\Form\Backend\UserFormEdit;
use Tuvais\UserBundle\Form\Backend\ChangePass;
use Tuvais\UserBundle\Form\ForgetForm;
use Tuvais\UserBundle\Document\Ticket;

class TicketController extends BaseController {

    /**
     * @Route("/", name="admin_ticket_ticket_index")
     * @Template()
     */
    public function indexAction() {
        $rep = $this->get('doctrine.odm.mongodb.document_manager');
        $dados = $rep->getRepository("TuvaisTicketBundle:Ticket")->findAllByCreated();
        $itens = array();
        $titulo = $this->trans("Listagem de Ingressos");

        return $this->render('TuvaisTicketBundle:Backend/Ticket:index.html.twig', array(
                    'title' => $titulo,
                    'usuarios' => $dados));
    }

    /**
     * @Route("/novo", name="admin_user_user_new")
     * @Route("/editar/{username}", name="admin_user_user_edit")
     * @Template()
     */
    public function newAction($username = false) {
        if ($username) {

            $rep = $this->mongo('TuvaisUserBundle:User');
            $query = $rep->findByField('username', $username);
            if ($query->superadmin()) {
                if (!$this->hasRole("ROLE_SUPERADMIN")) {
                    $msg = $this->trans('Você não tem permissão para editar este usuário.');
                    $this->get('session')->setFlash('error', $msg);
                    return $this->redirect($this->generateUrl('_home'));
                }
            }
            $titulo = $this->trans("Edição do usuário %name%", array("%name%" => $query->getName()));
            $form = $this->createForm(new UserFormEdit(), $query);
            return $this->render('TuvaisUserBundle:Backend/User:novo.html.twig', array(
                        'form' => $form->createView(), 'title' => $titulo,
                        'usuario' => $query
                    ));
        } else {
            $factory = $this->get('form.factory');
            $titulo = $this->trans("Novo usuário");
            $form = $factory->create(new UserForm());
            return $this->render('TuvaisUserBundle:Backend/User:novo.html.twig', array(
                        'form' => $form->createView(), 'title' => $titulo,
                        'usuario' => null,
                        'current' => 'admin_user_user_index'
                    ));
        }
    }

    /**
     * @Route("/bloquear", name="admin_user_user_block")
     * @Template()
     */
    public function deleteAction() {
        $request = $this->getRequest();
        $username = $request->get('username');
        if ('POST' == $request->getMethod()) {
            $id = $request->get('id');
            $usuario = $this->mongo('TuvaisUserBundle:User')->findOneById($id);
            if ($usuario->superadmin()) {
                if (!$this->hasRole("ROLE_SUPERADMIN")) {
                    $msg = $this->trans('Você não tem permissão para bloquear este usuário.');
                    $this->get('session')->setFlash('error', $msg);
                    return $this->redirect($this->generateUrl('_home'));
                }
            }
            $this->mongo('TuvaisUserBundle:User')->block($usuario);
            $nome = $usuario->getName();
            $uname = $usuario->getUsername();
            $msg = $this->trans('O usuário %name% foi bloqueado com sucesso.', array("%name%" => $nome . " ($uname)"));
            $this->get('session')->setFlash('ok', $msg);
            return $this->redirect($this->generateUrl('admin_user_user_index'));
        } else {
            $usuario = $this->mongo('TuvaisUserBundle:User')->findOneBy(array('username' => $username));
            return $this->confirm($this->trans('Tem certeza que deseja bloquear o usuário %name%?', array("%name%" => $usuario->getName())), array('id' => $usuario->getId()));
        }
    }

}