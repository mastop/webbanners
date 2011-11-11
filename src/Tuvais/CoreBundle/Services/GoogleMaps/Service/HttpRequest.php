<?php
namespace Tuvais\CoreBundle\Services\GoogleMaps\Service;

use Symfony\Component\HttpFoundation\ParameterBag;
use Tuvais\CoreBundle\Services\GoogleMaps\Service\Exception;

class HttpRequest
{
    /* @var string */
    protected $url;

    /* @var ParameterBag */
    public $query;


    public function __construct($url = null, array $query = array())
    {
        $this->url = $url;
        $this->query = new ParameterBag($query);
    }

    /**
* @param string $url
*/
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
* @return string
*/
    public function getUrl()
    {
        return $this->url;
    }

    public function getResponse()
    {
        $query = http_build_query($this->query->all(), null, '&');
        $uri = $this->url . '?' . $query;

        if (!$result = file_get_contents($uri)) {
            throw new Exception(sprintf('Request for uri: "%s" has failed', $uri));
        }

        return $result;
    }

    /**
* @param ParameterBag $query
*/
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
* @return ParameterBag
*/
    public function getQuery()
    {
        return $this->query;
    }
}