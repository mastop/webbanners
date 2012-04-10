<?php

namespace Banner\CoreBundle\Controller\Backend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Banner\CoreBundle\Form\BannerType;
use Banner\CoreBundle\Form\BannerOfferType;
use Banner\CoreBundle\Document\Banner;
use Banner\CoreBundle\Util\Upload;

/**
 * Controller para administrar (CRUD) Banners.
 */

class BannerController extends BaseController
{
    /**
     * Lista todas os Banners
     * 
     * @Route("/", name="admin_core_banner_index")
     * @Template()
     */
    public function indexAction()
    {
        $title = 'Administração de Banners';
        $banner = $this->mongo('BannerCoreBundle:Banner')->findAll();
        return array(
            'banner'  => $banner,
            'title'   => $title,
            'current' => 'admin_core_banner_index',);
    }
    
    /**
     * Adiciona um novo, edita um já criado e salva ambos
     * control = false Banner normal
     * control = true Oferta
     * 
     * @Route("/novo/{control}", name="admin_core_banner_new", defaults={"control" = false})
     * @Route("/editar/{id}/{control}", name="admin_core_banner_edit", defaults={"control" = false})
     * @Route("/salvar/{id}", name="admin_core_banner_save", defaults={"id" = null})
     * @Template()
     */
    public function bannerAction($id = null, $control = false)
    {
        $dm = $this->dm();
        $title = ($id) ? "Editar Banner" : "Novo Banner";
        if($id){
            $banner = $this->mongo('BannerCoreBundle:Banner')->find($id);
            if(!$banner) throw $this->createNotFoundException ('Nenhum banner encontrado com o ID: "' . $id . '"');
        }else{
            $banner = new Banner();
            $banner->setUrl('http://');
        }
        $formType = (!$control) ? new BannerType() : new BannerOfferType();
        $form = $this->createForm($formType, $banner);
        $request = $this->get('request');
        if('POST' == $request->getMethod()){
            $form->bindRequest($request);
            $query = $request->request->get($form->getName());
            $data = $request->request->get($form->getName());
            $fileData = $request->files->get($form->getName());
            if($fileData['logo'] != null){
                if($id){
                    @unlink($banner->getPath() . "/" . $banner->getFileName());
                }
                $file = new Upload($fileData['logo']);
                $file->setPath($this->get('kernel')->getRootDir() . "/../web/uploads/bannercore/banner");
                $fileUploaded = $file->upload();
                $banner->setFilename($fileUploaded->getFileName());
                $banner->setFilesize($fileUploaded->getFileUploaded()->getClientSize());
                if ($file->getPath() != ""){
                    $banner->setPath($fileUploaded->getPath());
                }else {
                    $banner->setPath($fileUploaded->getDeafaultPath());
                }
            }
            $dm->persist($banner);
            $dm->flush();
            $this->get('session')->setFlash('ok', $this->trans(($id) ? "Banner Editado" : "Banner Criado" ));
            return $this->redirect($this->generateUrl('admin_core_banner_index'));
            
        }
        return array(
            'id'  => $id,
            'control'  => $control,
            'form'     => $form->createView(),
            'banner'   => $banner,
            'title'    => $title,
            'current'  => 'admin_core_banner_index',
        );
    }
    
    /**
     * Exibe um pre delete e deleta se for confirmado
     * 
     * @Route("/deletar/{id}", name="admin_core_banner_delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $request = $this->get('request');
        $formResult = $request->request;
        $dm = $this->dm();
        $banner = $this->mongo('BannerCoreBundle:Banner')->find($id);
        if($request->getMethod() == 'POST'){
            if (!$banner) throw $this->createNotFoundException($this->trans('Nenhum banner encontrado com o ID %id%',array('%id%'=>$id)));
            $dm->remove($banner);
            $dm->flush();
            return $this->redirectFlash($this->generateUrl('admin_core_banner_index'), $this->trans('E-mail Deletado'));
        }
        return $this->confirm($this->trans('Tem certeza que deseja deletar o banner %name%?', array("%name%" => $banner->getTitle())), array('id' => $banner->getId()));

    }
    
    /**
     * Ativa e Desativa um banner
     * 
     * @Route("/ativar/{id}/{active}", name="admin_core_banner_active", defaults={"active" = false})
     */
    public function activeAction($id, $active = false){
        $dm = $this->dm();
        $banner = $this->mongo('BannerCoreBundle:Banner')->find($id);
        ($active) ? $banner->setActive(true) : $banner->setActive(false);
        $dm->persist($banner);
        $dm->flush();
        return $this->redirect($this->generateUrl('admin_core_banner_index'));
    }
    
    /**
     * Url dinamica do script
     * 
     * @Route("/scriptjs", name="admin_core_banner_script")
     */
    public function scriptAction() {
        $script = '
            var ajaxPath = "' . $this->generateUrl('admin_core_banner_ajax', array(), true) . '";
            var errorMsg = "' . $this->trans('Erro ao executar o Ajax.') . '";
            ';
        return new Response($script);
    }
    
    /**
     * Ajax dos users
     * 
     * @route("/ajax", name="admin_core_banner_ajax")
     */
    public function ajaxAction()
    {
        if ($this->get('request')->isXmlHttpRequest()) {
            if ($this->get('request')->getMethod() == 'GET') {
                $user = $this->get('request')->query->get('q');
                $regexp = new \MongoRegex('/' . $user . '/i');
                $qb = $this->mongo('BannerUserBundle:User')->createQueryBuilder();
                $source = $qb->sort('name', 'ASC')
                        ->field('email')->equals($regexp)
                        ->addOr($qb->expr()->field('name')->equals($regexp))
                        ->addOr($qb->expr()->field('username')->equals($regexp))
                        ->getQuery()
                        ->execute();
                $data = '';
                foreach($source as $k => $v){
                    $data .= $v->getName().' ('.$v->getEmail().')';
                    $data .= '|';
                    $data .= $v->getId();
                    $data .= " \n";
                }
                return new Response($data);
            }
        }else{
            return $this->redirectFlash($this->generateUrl('_home'), $this->trans('Área restrita!'), 'error');
        }
    }
}