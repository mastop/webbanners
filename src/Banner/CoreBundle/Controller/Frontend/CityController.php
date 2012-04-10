<?php
namespace Banner\CoreBundle\Controller\Frontend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Banner\CoreBundle\Document\City;

/**
 * Controller que cuidará de setar a cidade escolhida na session do usuário.
 */

class CityController extends BaseController
{
    /**
     * @Route("/ofertas-em-{slug}", name="core_city_index", requirements={"_scheme" = "http"})
     * @Template()
     */
    public function indexAction(City $city)
    {
        $this->get('session')->set('banner.user.city', $city->getSlug());
        $this->get('session')->set('banner.user.cityName', $city->getName());
        $this->get('session')->set('banner.user.cityId', $city->getId());
        $breadcrumbs[]['title'] = $city->getName();
        return array('breadcrumbs'=>$breadcrumbs);
    }
}
