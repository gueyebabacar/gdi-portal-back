<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityRepository;
use Guzzle\Http\Client;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Psr7\Request;
use PortalBundle\Entity\Agency;
use PortalBundle\Service\CurlService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CurlServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    public $containerProphecy;

    /**
     * @var  CurlService
     */
    private $curlService;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

        $this->containerProphecy = $this->prophet->prophesize(ContainerInterface::class);

        /** @var ContainerInterface $container */
        $container = $this->containerProphecy->reveal();

        $this->curlService = new CurlService($container);
    }


    /**
     * testSendRequest
     * @test
     * @group curlService
     * @group services
     */
    public function testSendRequest()
    {
        $url = 'url';
        $parameters['headers'] = [];
        $parameters['parameters'] = [];

        $clientProphecy = $this->prophet->prophesize(Client::class);
        $curlResquestProphecy = $this->prophet->prophesize(Request::class);
        $resquestProphecy = $this->prophet->prophesize(\Symfony\Component\HttpFoundation\Request::class);
        $promiseProphecy = $this->prophet->prophesize(Promise::class);

        $this->containerProphecy
            ->get('request')
            ->willReturn($resquestProphecy->reveal())
            ->shouldBeCalled();
        $resquestProphecy
            ->getMethod()
            ->willReturn()
            ->shouldBeCalled();

        $clientProphecy
            ->send($curlResquestProphecy->reveal())
            ->willReturn($promiseProphecy->reveal())
            ->shouldBeCalled();

//        $promiseProphecy
//            ->getHeaders()
//            ->willReturn($parameters['headers'])
//            ->shouldBeCalled();

        $this->curlService->sendRequest($url, $parameters);
    }


    /**
     * testSendRequest
     * @test
     */
    public function testSendRequestFail()
    {
        $url = 'url';
        $parameters['headers'] = [];
        $parameters['parameters'] = [];

        $clientProphecy = $this->prophet->prophesize(Client::class);
        $curlResquestProphecy = $this->prophet->prophesize(Request::class);
        $resquestProphecy = $this->prophet->prophesize(\Symfony\Component\HttpFoundation\Request::class);
        $promiseProphecy = $this->prophet->prophesize(Promise::class);

        $this->containerProphecy
            ->get('request')
            ->willReturn($resquestProphecy->reveal());
        $resquestProphecy
            ->getMethod()
            ->willReturn();
        $clientProphecy
            ->send($curlResquestProphecy->reveal())
            ->willReturn($promiseProphecy->reveal());

        $this->curlService->sendRequest($url, $parameters);
    }
}
