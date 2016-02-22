<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PortalBundle\Entity\Region;
use PortalBundle\Service\RegionService;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RegionServiceTest extends \PHPUnit_Framework_TestCase
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
    public $authorizationCheckerProphecy;

    /**
     * @var  RegionService
     */
    private $agencyService;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

        $this->emProphecy = $this->prophet->prophesize(EntityManager::class);

        /** @var EntityManager $em */
        $em = $this->emProphecy->reveal();

        $this->authorizationCheckerProphecy = $this->prophet->prophesize(AuthorizationCheckerInterface::class);

        /** @var AuthorizationChecker $authorizationChecker */
        $authorizationChecker = $this->authorizationCheckerProphecy->reveal();

        $this->agencyService = new RegionService($em, $authorizationChecker);
    }

    /**
     * tesGetAgenciesFromRegionSecured
     */
    public function testGetAgenciesFromRegionSecured()
    {
        $agenciesSent = [];

        $agencies = [
            new Region()
        ];

        $repositoryProphecy = $this->prophet->prophesize(EntityRepository::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Region")
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $repositoryProphecy
            ->findAll()
            ->willReturn($agencies)
            ->shouldBeCalled();

        $this->authorizationCheckerProphecy
            ->isGranted('view', $agencies[0])
            ->willReturn(true);

        $agenciesSent[] = $agencies[0];

        $this->agencyService->getRegionsSecured();

        $this->assertEquals($agencies[0], $agenciesSent[0]);
    }
}
