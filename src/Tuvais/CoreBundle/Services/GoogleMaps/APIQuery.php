<?php
namespace Tuvais\CoreBundle\Services\GoogleMaps;

use Tuvais\CoreBundle\Services\GoogleMaps\Service\Result;
use Tuvais\CoreBundle\Document\City;
use Tuvais\CoreBundle\Document\Coordinates;


class GeocodeAPIQuery extends QueryAbstract
{
    protected $serviceUri = 'http://maps.googleapis.com/maps/api/geocode/';

    public function __construct(array $parameters = array(), $format = 'json')
    {
        $this->allowedFormats = array('json', 'xml');
        $this->result = new Result();
        
        parent::__construct($parameters, $format);
    }

    /**
* @return Tuvais\CoreBundle\Services\GoogleMaps\Service\Result
*/
    protected function parseResponse($response)
    {
        switch(mb_strtolower($this->format)) {
            case 'json':
                $this->parseJson($response);
            break;

            case 'xml':
                $this->parseXml($response);
            break;
        }

        return $this->result;
    }

    protected function parseJson($json)
    {
        $response = json_decode($json, true);
        if (!is_array($response)) {
            $this->setResultStatus(Result::STATUS_INVALID_RESPONSE, false);
            return;
        }
        
        if (!array_key_exists('results', $response) || !array_key_exists('status', $response)) {
            $this->setResultStatus(Result::STATUS_INVALID_RESPONSE, false);
            return;
        }

        $resultCount = count($response['results']);
        if ($resultCount <= 0) {
            $this->setResultStatus(Result::STATUS_ZERO_RESULTS, false);
            return;
        }

        if ($resultCount > 1) {
            $this->setResultStatus(Result::STATUS_NOT_SPECIFIC_ENOUGH, false);
            return;
        }

        $data = $response['results'][0];
        $status = $response['status'];

        $arrayData = array(
            'address' => array(),
            'coordinates' => array()
        );

        // parsing address
        foreach($data['address_components'] as $addressPart) {
            if (array_key_exists('types', $addressPart)) {
                foreach($addressPart['types'] as $type) {
                    if ('political' != $type) {
                        $arrayData['address'][$type] = $addressPart;
                    }
                    unset($arrayData['address'][$type]['types']);
                }
            }
        }
        if (array_key_exists('formatted_address', $data)) {
            $arrayData['city']['formatted_address'] = $data['formatted_address'];
        }

        // parsing coordinates
        $arrayData['coordinates']['latitude'] = $data['geometry']['location']['lat'];
        $arrayData['coordinates']['longitude'] = $data['geometry']['location']['lng'];

        return $this->buildResult($arrayData, $status);
    }

    private function parseXml($xml)
    {
        // TODO
    }

    private function buildResult(array $arrayData, $status)
    {
        $address = new City();
        if (array_key_exists('street_number', $arrayData['address'])) {
            $address->setStreetNumber($arrayData['address']['street_number']['long_name']);
        }
        

        $corrdinates = new Coosdinates();
        $coodinates->setLatitude($arrayData['coordinates']['latitude']);
        $coordinates->setLongitude($arrayData['coordinates']['longitude']);

        $this->result->setAddress($address);
        $this->result->setCoordinates($coordinates);
        $this->result->setSuccess(true);

        $this->buildStatus($status);

        return $this->result;
    }

    protected function buildStatus($status)
    {
        switch(mb_strtolower($status)) {
            case 'ok':
                $this->setResultStatus(Result::STATUS_OK, true);
            break;

            case 'zero_results':
                $this->setResultStatus(Result::STATUS_ZERO_RESULTS, false);
            break;

            case 'over_query_limit':
                $this->setResultStatus(Result::STATUS_OVER_QUERY_LIMIT, false);
            break;

            case 'request_denied':
                $this->setResultStatus(Result::STATUS_REQUEST_DENIED, false);
            break;

            case 'invalid_request':
                $this->setResultStatus(Result::STATUS_INVALID_REQUEST, false);
            break;

            default:
                $this->setResultStatus(Result::STATUS_INVALID_RESPONSE, false);
        }
    }

    protected function setResultStatus($status, $success)
    {
        $this->result->setStatus($status);
        $this->result->setSuccess($success);
    }
}