<?php

namespace PortalBundle\Service;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use JMS\DiExtraBundle\Annotation as DI;
use Lsw\ApiCallerBundle\Call\HttpDeleteJson;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use Lsw\ApiCallerBundle\Call\HttpPostJson;
use Lsw\ApiCallerBundle\Call\HttpPutJson;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as CurlRequest;

/**
 * Class CurlService
 *
 * @DI\Service("portal.service.curl", public=true)
 *
 * @package PortalBundle\Service
 */
class CurlService
{
    /**
     * @DI\Inject("service_container")
     * @var ContainerInterface
     */
    public $container;

    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $url;

    /**
     * ControlService constructor.
     * @param ContainerInterface $container
     *
     * @DI\InjectParams({
     *     "container" = @DI\Inject("service_container"),
     * })
     */
    public function __construct($container)
    {
        $this->container = $container;
        $request = $this->container->get('request');
        $this->method = $request->getMethod();
    }

    /**
     * @param $url
     * @param $parameters
     * @return mixed
     */
    public function sendRequest($url, $parameters)
    {
        $client = new Client();

//        $curl = $this->container->get('api_caller');
//        $output = $curl->call($this->requestDispatcher($url, $parameters['profile'], []));

        try {
            $response = $client->send($this->requestDispatcher($url, $parameters));

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            dump($e->getRequest());
            $error['code'] = $e->getCode();
            $error['message'] = $e->getMessage();
            return $error;
        }

    }

    /**
     * @param $url
     * @param $parameters
     * @return CurlRequest
     */
    private function requestDispatcher($url, $parameters)
    {
        return new CurlRequest($this->method, $url, $parameters['headers'], $parameters['parameters']);
//        switch($this->method){
//            case 'GET':
//                return new HtZtpGetJson($url,$headers,  $parameters);
//                return new CurlRequest('GET', $url, $headers, '');
//                break;
//
//                break;
//            case 'POST':
//                return new HttpPostJson($url, $parameters);
//                break;
//            case 'PUT':
//                return new HttpPutJson($url, $parameters);
//                break;
//            case 'DELETE':
//                return new HttpDeleteJson($url, $parameters);
//                break;
//            default:
//                return null;
//                break;
//        }
    }
}