<?php

namespace Tuvais\CoreBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tuvais\CoreBundle\Util\IPtoCity;
use Symfony\Component\HttpFoundation\Request;

class KernelRequestListener
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if(HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            if ($session = $event->getRequest()->getSession()) {
                // Pegar a cidade
                if(!$session->has('tuvais.user.city')) {
                    $ip2city = new IPtoCity($this->container, $_SERVER['REMOTE_ADDR']);
                    $cidade = (string)$this->container->get('mastop')->slugify($ip2city->getCity());
                    $session->set('tuvais.user.ip', (string)$ip2city->getIP());
                    $cidadeDB = $this->container->get('mastop')->getDocumentManager()->getRepository('TuvaisCoreBundle:City')->findBySlug($cidade);
                    $nacionalDB = $this->container->get('mastop')->getDocumentManager()->getRepository('TuvaisCoreBundle:City')->findBySlug('oferta-nacional');
                    if($cidadeDB){ // Cidade atual está no DB
                        $session->set('tuvais.user.city', $cidade);
                        $session->set('tuvais.user.cityName', $cidadeDB->getName());
                        $session->set('tuvais.user.cityId', $cidadeDB->getId());
                    }else{
                        $cidadeDB = $this->container->get('mastop')->getDocumentManager()->getRepository('TuvaisCoreBundle:City')->findBySlug($this->container->getParameter('tuvais.default_city'));
                        if($cidadeDB){
                            $session->set('tuvais.user.city', $this->container->getParameter('tuvais.default_city')); // Cidade atual não está no DB, então seta a cidade padrão como atual
                            $session->set('tuvais.user.cityName', $cidadeDB->getName());
                            $session->set('tuvais.user.cityId', $cidadeDB->getId());
                        }else{ // Cidade padrão não foi encontrada no DB (isso é ruim)
                            $session->set('tuvais.user.city', $cidade);
                            $session->set('tuvais.user.cityName', $ip2city->getCity());
                            $session->set('tuvais.user.cityId', '0');
                        }
                    }
                    if($nacionalDB){ // Guarda o ID da Oferta Nacional na session
                        $session->set('tuvais.user.nacional', $nacionalDB->getId());
                    }
                    $session->set('tuvais.user.country', (string)$ip2city->getCountry());
                    $coords = $ip2city->getCoordinates();
                    if(isset ($coords['lati']) && isset ($coords['long'])){
                        $session->set('tuvais.user.lati', (string)$coords['lati']);
                        $session->set('tuvais.user.long', (string)$coords['long']);
                    }
                }
            } else {
                // sessionless request, use explicit requested locale
                $locale = $this->container->get('request')->request->get('locale', 'pt_BR');
                $this->container->get('translator')->setLocale($locale);
            }
            //Pegar o father do usuário
            if($this->container->get('request')->query->get('u')){
                if(!$this->container->get('request')->getSession()->get('u')){
                    $this->container->get('request')->getSession()->set('u', $this->container->get('request')->query->get('u'));
                }
            }
        }
    }
}
