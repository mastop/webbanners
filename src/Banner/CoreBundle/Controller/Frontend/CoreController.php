<?php
namespace Banner\CoreBundle\Controller\Frontend;

use Mastop\SystemBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controller que cuidará de setar a cidade escolhida na session do usuário.
 */

class CoreController extends BaseController
{
    /**
     * @Route("/", name="_home", requirements={"_scheme" = "http"})
     * @Template()
     */
    public function indexAction()
    {
        return array('Teste' => 'Teste');
    }
    /**
     * @Route("/pacotes/{pacote}", name="_package", defaults={"pacote"=""})
     * @Template()
     */
    public function packageAction($pacote="")
    {
        return $this->render('BannerCoreBundle:Frontend:Package\package'.$pacote.'.html.twig');
    }
    /**
     * @Route("/faq/{topico}", name="_faq", defaults={"topico"=""})
     * @Template()
     */
    public function faqAction($topico="")
    {
        return $this->render('BannerCoreBundle:Frontend:FAQ\faq'.$topico.'.html.twig');
    }
}
