<?php

namespace PortalBundle\Tests\Controller\ProxyController;

use PortalBundle\Tests\BaseWebTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProxyOpticControllerTest extends BaseWebTestCase
{

    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    public $tokenStorageProphecy;

    /**
     * @var ObjectProphecy
     */
    public $containerProphecy;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

    }
    /**
     * @test
     * testGetCurrentUser
     */
    public function testGetCurrentUser()
    {
        $tokenStorageProphecy = $this->prophet->prophesize(TokenStorage::class);

        $tokenStorageProphecy
            ->getToken()
            ->willReturn()
            ->shouldBeCalled();
    }

    /**
     * @test
     * testRedirectGetGdiiAction
     */
    public function testRedirectGetGdiiAction()
    {
        $this->testGetCurrentUser();
        $containerProphecy = $this->prophet->prophesize(ContainerInterface::class);
        $resquestProphecy = $this->prophet->prophesize(\Symfony\Component\HttpFoundation\Request::class);

        $containerProphecy
            ->getParameter()
            ->willReturn()
            ->shouldBeCalled();

        $resquestProphecy
            ->getQueryString()
            ->willReturn()
            ->shouldBeCalled();
    }
}
