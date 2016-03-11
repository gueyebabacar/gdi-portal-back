<?php

namespace PortalBundle\Service;

use GuzzleHttp\Exception\RequestException;
use JMS\DiExtraBundle\Annotation as DI;
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
    }

    /**
     * @param $url
     * @param $parameters
     * @return mixed
     */
    public function sendRequest($url, $parameters)
    {
        $this->method = $this->container->get('request')->getMethod();
        $client = new Client();
        try {
            $response = $client->send($this->request($url, $parameters));

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
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
    private function request($url, $parameters)
    {
        return new CurlRequest($this->method, $url, $parameters['headers'], $parameters['parameters']);
    }
}