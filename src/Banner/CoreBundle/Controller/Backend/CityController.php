<?php

namespace Banner\CoreBundle\Controller\Backend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Banner\CoreBundle\Document\City;
use Banner\CoreBundle\Document\Coordinates;
use Banner\CoreBundle\Form\CityType;
use Banner\CoreBundle\Form\CityEditType;
use Banner\CoreBundle\Services\GoogleMaps\APIQuery;

/**
 * Controller para administrar (CRUD) cidades.
 */
class CityController extends BaseController {

    /**
     * Lista todas as cidades
     * 
     * @Route("/", name="admin_core_city_index")
     * @Template()
     */
    public function indexAction() {
        //$cidades = $this->mongo('BannerCoreBundle:City')->findAll();
        $cidades = $this->mongo('BannerCoreBundle:City')->findAllByOrder();
        return array('cidades' => $cidades, 'title' => $this->trans("Listagem de Cidades"));
    }

    /**
     * Adiciona um novo, edita um já criado e salva ambos
     * 
     * @Route("/form/{slug}", name="admin_core_city_form", defaults={"slug" = null})
     * @Template()
     */
    public function formAction(City $city = null) {
        $dm = $this->dm();
        $title = ($city) ? "Editar Cidade" : "Nova Cidade";
        $msg = ($city) ? "Cidade Alterada" : "Cidade Criada";
        if (!$city) {
            $city = new City();
            $form = $this->createForm(new CityType(), $city);
        }else{
            $form = $this->createForm(new CityEditType(), $city);
        }
        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                if ($city->getId() == '' ) {
                    //Google Maps Service  
                    $geo = new APIQuery(array(
                                'address' => $city->getName() . ',' . $city->getState() . ',' . 'Brazil',
                                'sensor' => 'false',
                            ));
                    $lat = $geo->getResult()->getCoordinates()->getLatitude();
                    $long = $geo->getResult()->getCoordinates()->getLongitude();

                    $coordinates = new Coordinates();
                    $coordinates->setLatitude($lat);
                    $coordinates->setLongitude($long);
                    $city->setCoordinates($coordinates);
                }
                $dm->persist($city);
                $dm->flush();
                return $this->redirectFlash($this->generateUrl('admin_core_city_index'), $msg);
            }
        }
        return array('form' => $form->createView(), 'city' => $city, 'title' => $title, 'current' => 'admin_core_city_index');
    }

    /**
     * Exibe um pre delete e deleta se for confirmado
     * 
     * @Route("/deletar/{id}", name="admin_core_city_delete")
     * @Template()
     */
    public function deleteAction(City $city) {
        // Adicionado para impedir remoção por causa do crawler
        return $this->redirectFlash($this->generateUrl('admin_core_city_index'), 'Não é possível remover cidades devido à integração com o Crawler.', 'error');
        if ($this->get('request')->getMethod() == 'POST') {
            $this->dm()->remove($city);
            $this->dm()->flush();
            return $this->redirectFlash($this->generateUrl('admin_core_city_index'), 'Cidade Deletada!');
        }
        return $this->confirm('Tem certeza de que deseja remover a cidade "' . $city->getName() . '"?', array('id' => $city->getId()));
    }

}
