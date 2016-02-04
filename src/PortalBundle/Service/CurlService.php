<?php

namespace PortalBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;
use Lsw\ApiCallerBundle\Call\HttpDeleteJson;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use Lsw\ApiCallerBundle\Call\HttpPostJson;
use Lsw\ApiCallerBundle\Call\HttpPutJson;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * @param Request $request
     * @param $url
     * @param $parameters
     * @return mixed
     */
    public function sendRequest(Request $request, $url, $parameters){
//        $this->container->get('api_caller')->setOption(CURLOPT_HTTPHEADER);
        $output = $this->container->get('api_caller')->call($this->requestDispatcher($url,[]));
        dump(json_encode($output));exit;
        $array = [];
        foreach (reset($output) as $item) {
            $array[] = $item;
        }
//        dump(reset($output)); exit;
        dump(reset($output)[0]);
        return reset($output)[0];
    }

    /**
     * @param $url
     * @param $parameters
     * @return HttpDeleteJson|HttpGetJson|HttpPostJson|HttpPutJson|null
     */
    private function requestDispatcher($url, $parameters)
    {
        switch($this->method){
            case 'GET':
                return new HttpGetJson($url, $parameters);
                break;
            case 'POST':
                return new HttpPostJson($url, $parameters);
                break;
            case 'PUT':
                return new HttpPutJson($url, $parameters);
                break;
            case 'DELETE':
                return new HttpDeleteJson($url, $parameters);
                break;
            default:
                return null;
                break;
        }
    }
}