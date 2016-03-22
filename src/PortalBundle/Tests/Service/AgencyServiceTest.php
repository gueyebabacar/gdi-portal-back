<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PortalBundle\Entity\Agency;
use PortalBundle\Service\AgencyService;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AgencyServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  AgencyService
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

        $this->agencyService = new AgencyService($em, $authorizationChecker);
    }

    /**
     * tesGetAgenciesFromRegionSecured
     */
    public function testGetAgenciesFromRegionSecured()
    {
        $agenciesSent = [];

        $agencies = [
            new Agency()
        ];

        $repositoryProphecy = $this->prophet->prophesize(EntityRepository::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $repositoryProphecy
            ->findBy(['region' => '1'])
            ->willReturn($agencies)
            ->shouldBeCalled();

        $this->authorizationCheckerProphecy
            ->isGranted('view', $agencies[0])
            ->willReturn(true);

        $agenciesSent[] = $agencies[0];

        $this->agencyService->getAgenciesFromRegionSecured(1);

        $this->assertEquals($agencies[0], $agenciesSent[0]);
    }
}
