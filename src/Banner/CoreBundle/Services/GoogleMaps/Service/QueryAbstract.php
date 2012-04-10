<?php
namespace Banner\CoreBundle\Services\GoogleMaps\Service;

use Symfony\Component\HttpFoundation\ParameterBag;


abstract class QueryAbstract
{
    protected $serviceUri;
    public $parameters;
    protected $response;
    protected $result;
    protected $format;
    protected $allowedFormats = array();

    public function __construct(array $parameters = array(), $format)
    {
        $this->parameters = new ParameterBag($parameters);
        $this->setFormat($format);
    }

    public function setServiceUri($serviceUri)
    {
        $this->serviceUri = $serviceUri;
    }

    public function getServiceUri()
    {
        return $this->serviceUri;
    }

    public function setFormat($format)
    {
        if (!in_array($format, $this->allowedFormats)) {
            throw new \InvalidArgumentException(sprintf('The format "%s" is not accepted', $format));
        }
        
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getResult()
    {
        if (empty($this->serviceUri)) {
            throw new \InvalidArgumentException('The service URI must be defined!');
        }

        $url = rtrim($this->serviceUri , '/');
        $url.= '/' . $this->getFormat();
        
        $request = new HttpRequest($url);
        $request->query->add($this->parameters->all());
        $response = $request->getResponse();

        return $this->parseResponse($response);
    }

    /**
* @return \Ano\Bundle\GoogleMapsBundle\Model\Result
     */
    abstract protected function parseResponse($response);

}