<?php

namespace Tuvais\CoreBundle\Services\GoogleMaps\Service;

use Tuvais\CoreBundle\Document\City;
use Tuvais\CoreBundle\Document\Coordinates;

class Result {
    /*
    const STATUS_OK = 'OK';
    const STATUS_ZERO_RESULTS = 'ZERO_RESULTS';
    const STATUS_OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const STATUS_REQUEST_DENIED = 'REQUEST_DENIED';
    const STATUS_INVALID_REQUEST = 'INVALID_REQUEST';
    const STATUS_INVALID_RESPONSE = 'INVALID_RESPONSE';
    const STATUS_NOT_SPECIFIC_ENOUGH = 'NOT_SPECIFIC_ENOUGH';
*/
    /* @var City */

    protected $address;

    /* @var Coordinates */
    protected $coordinates;

    /**
     * @param City $address
     */
    public function setAddress(City $address) {
        $this->address = $address;
    }

    /**
     * @return City
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param Coordinates $coordinates
     */
    public function setCoordinates(Coordinates $coordinates) {
        $this->coordinates = $coordinates;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates() {
        return $this->coordinates;
    }

}