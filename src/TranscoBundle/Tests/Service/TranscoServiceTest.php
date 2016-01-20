<?php

namespace TranscoBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use TranscoBundle\Repository\TranscoAgenceRepository;
use TranscoBundle\Repository\TranscoDiscoRepository;
use TranscoBundle\Repository\TranscoOpticRepository;
use TranscoBundle\Service\TranscoService;

class TranscoServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    private $emProphecy;

    /**
     * @var ObjectProphecy
     */
    private $transcoDiscoRepoProphecy;

    /**
     * @var ObjectProphecy
     */
    private $transcoOpticRepoProphecy;

    /**
     * @var ObjectProphecy
     */
    private $transcoAgenceRepoProphecy;

    /**
     * @var TranscoService
     */
    private $transcoService;



    public function setUp()
    {
        $this->prophet = new Prophet();
        $this->emProphecy = $this->prophet->prophesize(EntityManager::class);
        $this->transcoAgenceRepoProphecy = $this->prophet->prophesize(TranscoAgenceRepository::class);
        $this->transcoDiscoRepoProphecy = $this->prophet->prophesize(TranscoDiscoRepository::class);
        $this->transcoOpticRepoProphecy = $this->prophet->prophesize(TranscoOpticRepository::class);

        /** @var EntityManager $em */
        $em = $this->emProphecy->reveal();
        $this->transcoService = new TranscoService($em);
    }

    public function testGetDelegationBUResponse()
    {
        $this->markTestIncomplete();
        $criteria = [
            [
                "name" => "TypeDeTravail",
                "value" => "INS"
            ]
        ];

        $result = [
            [
                "codeNatInter" => "codeNat"
            ]
        ];

        $this->transcoOpticRepoProphecy
            ->findDelegationBI($criteria)
            ->willReturn($result)
            ->shouldBeCalled();

        $return = $this->transcoService->getDelegationBiResponse($criteria);
    }
}
