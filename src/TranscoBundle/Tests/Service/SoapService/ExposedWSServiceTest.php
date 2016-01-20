<?php

namespace TranscoBundle\Tests\Service\SoapService;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use TranscoBundle\Service\SoapService\ExposedWSService;
use TranscoBundle\Service\TranscoService;

class ExposedWSServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    public $transcoServiceProphecy;

    /**
     * @var ExposedWSService
     */
    public $exposedWSService;

    /**
     *
     */
    public function setUp()
    {
        $this->prophet = new Prophet();
    }

    /**
     * @test
     * @group transco
     */
    public function testDelegationOTTranscoService()
    {
        $criteria = [
            [
                "name" => "TypeDeTravail",
                "value" => "INS"
            ]
        ];

        $return = [
            [
                "name" => "GroupeDeGamme",
                "value" => "Test"
            ]
        ];

        $data = new \stdClass();

        $data->delegationOTTranscoGDIServiceInput = new \stdClass();
        $data->delegationOTTranscoGDIServiceInput->Critere = [];

        $this->transcoServiceProphecy = $this->prophet->prophesize(TranscoService::class);
        $this->transcoServiceProphecy
            ->getDelegationOtResponse($criteria)
            ->willReturn($return)
            ->shouldBeCalled();

        $transcoService = $this->transcoServiceProphecy->reveal();
        $this->exposedWSService = new ExposedWSService($transcoService);

        $result = $this->exposedWSService->delegationOTTranscoService($data);
        $this->assertEquals('delegationOTTranscoGDIServiceOutput', key($result));
    }

    /**
     * @test
     * @group transco
     */
    public function testDelegationBITranscoService()
    {
        $criteria = [
            [
                "name" => "TypeDeTravail",
                "value" => "INS"
            ]
        ];

        $return = [
            [
                "name" => "GroupeDeGamme",
                "value" => "Test"
            ]
        ];

        $data = new \stdClass();

        $data->delegationBITranscoGDIServiceInput = new \stdClass();
        $data->delegationBITranscoGDIServiceInput->Critere = [];

        $this->transcoServiceProphecy = $this->prophet->prophesize(TranscoService::class);
        $this->transcoServiceProphecy
            ->getDelegationBiResponse($criteria)
            ->willReturn($return)
            ->shouldBeCalled();

        $transcoService = $this->transcoServiceProphecy->reveal();
        $this->exposedWSService = new ExposedWSService($transcoService);

        $result = $this->exposedWSService->delegationBITranscoService($data);
        $this->assertEquals('delegationBITranscoGDIServiceOutput', key($result));
    }

    /**
     * @test
     * @group transco
     */
    public function testEnvoiDIRGTranscoService()
    {
        $criteria = [
            [
                "name" => "TypeDeTravail",
                "value" => "INS"
            ]
        ];

        $return = [
            [
                "name" => "GroupeDeGamme",
                "value" => "Test"
            ]
        ];

        $data = new \stdClass();

        $data->envoiDIRGTranscoGDIServiceInput = new \stdClass();
        $data->envoiDIRGTranscoGDIServiceInput->Critere = [];

        $this->transcoServiceProphecy = $this->prophet->prophesize(TranscoService::class);
        $this->transcoServiceProphecy
            ->getEnvoiDirgtResponse($criteria)
            ->willReturn($return)
            ->shouldBeCalled();

        $transcoService = $this->transcoServiceProphecy->reveal();
        $this->exposedWSService = new ExposedWSService($transcoService);

        $result = $this->exposedWSService->envoiDIRGTranscoService($data);
        $this->assertEquals('envoiDIRGTranscoGDIServiceOutput', key($result));
    }

    /**
     * @test
     * @group transco
     */
    public function testPublicationOTTranscoService()
    {
        $criteria = [
            [
                "name" => "TypeDeTravail",
                "value" => "INS"
            ]
        ];

        $return = [
            [
                "name" => "GroupeDeGamme",
                "value" => "Test"
            ]
        ];

        $data = new \stdClass();

        $data->publicationOTTranscoGDIServiceInput = new \stdClass();
        $data->publicationOTTranscoGDIServiceInput->Critere = [];

        $this->transcoServiceProphecy = $this->prophet->prophesize(TranscoService::class);
        $this->transcoServiceProphecy
            ->getPublicationOttResponse($criteria)
            ->willReturn($return)
            ->shouldBeCalled();

        $transcoService = $this->transcoServiceProphecy->reveal();
        $this->exposedWSService = new ExposedWSService($transcoService);

        $result = $this->exposedWSService->publicationOTTranscoService($data);
        $this->assertEquals('publicationOTTranscoGDIServiceOutput', key($result));
    }
}
