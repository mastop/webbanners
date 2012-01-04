<?php
namespace Tuvais\CoreBundle\Services\GoogleMaps\Service;

class Exception extends \RuntimeException
{
    public function __construct($message = 'Request failed', \Exception $previous = null)
    {
        parent::__construct($message, 500, $previous);
    }
}