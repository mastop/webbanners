<?php

namespace Banner\CoreBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Banner\CoreBundle\Util\IPtoCity;
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
                if(!$session->has('banner.user.city')) {
                    $ip2city = new IPtoCity($this->container, $_SERVER['REMOTE_ADDR']);
                    $cidade = (string)$this->container->get('mastop')->slugify($ip2city->getCity());
                    $session->set('banner.user.ip', (string)$ip2city->getIP());
                    $cidadeDB = $this->container->get('mastop')->getDocumentManager()->getRepository('BannerCoreBundle:City')->findBySlug($cidade);
                    $nacionalDB = $this->container->get('mastop')->getDocumentManager()->getRepository('BannerCoreBundle:City')->findBySlug('oferta-nacional');
                    if($cidadeDB){ // Cidade atual está no DB
                        $session->set('banner.user.city', $cidade);
                        $session->set('banner.user.cityName', $cidadeDB->getName());
                        $session->set('banner.user.cityId', $cidadeDB->getId());
                    }else{
                        $cidadeDB = $this->container->get('mastop')->getDocumentManager()->getRepository('BannerCoreBundle:City')->findBySlug($this->container->getParameter('banner.default_city'));
                        if($cidadeDB){
                            $session->set('banner.user.city', $this->container->getParameter('banner.default_city')); // Cidade atual não está no DB, então seta a cidade padrão como atual
                            $session->set('banner.user.cityName', $cidadeDB->getName());
                            $session->set('banner.user.cityId', $cidadeDB->getId());
                        }else{ // Cidade padrão não foi encontrada no DB (isso é ruim)
                            $session->set('banner.user.city', $cidade);
                            $session->set('banner.user.cityName', $ip2city->getCity());
                            $session->set('banner.user.cityId', '0');
                        }
                    }
                    if($nacionalDB){ // Guarda o ID da Oferta Nacional na session
                        $session->set('banner.user.nacional', $nacionalDB->getId());
                    }
                    $session->set('banner.user.country', (string)$ip2city->getCountry());
                    $coords = $ip2city->getCoordinates();
                    if(isset ($coords['lati']) && isset ($coords['long'])){
                        $session->set('banner.user.lati', (string)$coords['lati']);
                        $session->set('banner.user.long', (string)$coords['long']);
                    }
                }
            } else {
                // sessionless request, use explicit requested locale
                $locale = $this->container->get('request')->request->get('locale', 'pt_BR');
                $this->container->get('translator')->setLocale($locale);
            }
        }
    }
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $response = $event->getResponse();
        $request = $event->getRequest();
        // se é ajax, vaza
        if ($request->isXmlHttpRequest()) {
            return;
        }
        
        if($request->get('u')){ // Se tem U no request (POST, GET, o que for)
            $response->headers->setCookie(new Cookie(
                'bannerU',
                $request->get('u'),
                time() + 604800
            ));
        }
    }
}
