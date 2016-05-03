<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Repository\AgencyRepository;
use PortalBundle\Service\AgencyService;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;

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
     * @var ObjectProphecy
     */
    public $tokenStorageProphecy;

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

        $this->tokenStorageProphecy = $this->prophet->prophesize(TokenStorage::class);

        /** @var TokenStorage $tokenStorage */
        $tokenStorage = $this->tokenStorageProphecy->reveal();

        $this->agencyService = new AgencyService($em, $authorizationChecker, $tokenStorage);
    }

    /**
     * testGetAgenciesFromRegionSecuredAgencyContext
     * @test
     * @group agencyService
     * @group services
     */
    public function testGetAgenciesFromRegionSecuredAgencyContext()
    {
        $agenciesSent = [];

        $agencies = [
            new Agency()
        ];

        $user = new User();
        $user->setTerritorialContext(ContextEnum::AGENCY_CONTEXT);

        $agencyRepoProphecy = $this->prophet->prophesize(AgencyRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($agencyRepoProphecy->reveal())
            ->shouldBeCalled();

        $this->tokenStorageProphecy
            ->getToken()
            ->willReturn($tokenProphecy->reveal())
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $agenciesSent[] = $agencies[0];

        $this->agencyService->getAgenciesFromRegionSecured(1);

        $this->assertEquals($agencies[0], $agenciesSent[0]);
    }

    /**
     * testGetAgenciesFromRegionSecuredRegionContext
     * @test
     * @group agencyService
     * @group services
     */
    public function testGetAgenciesFromRegionSecuredRegionContext()
    {
        $agenciesSent = [];

        $agencies = [
            new Agency()
        ];

        $user = new User();
        $user->setTerritorialContext(ContextEnum::REGION_CONTEXT);

        $region = new Region();
        $region->addAgency(new Agency());

        $user->setRegion($region);

        $agencyRepoProphecy = $this->prophet->prophesize(AgencyRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($agencyRepoProphecy->reveal())
            ->shouldBeCalled();

        $this->tokenStorageProphecy
            ->getToken()
            ->willReturn($tokenProphecy->reveal())
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $agenciesSent[] = $agencies[0];

        $this->agencyService->getAgenciesFromRegionSecured(1);

        $this->assertEquals($agencies[0], $agenciesSent[0]);
    }

    /**
     * testGetAgenciesFromRegionSecuredNationalContext
     * @test
     * @group agencyService
     * @group services
     */
    public function testGetAgenciesFromRegionSecuredNationalContext()
    {
        $agenciesSent = [];

        $agencies = [
            new Agency()
        ];

        $user = new User();
        $user->setTerritorialContext(ContextEnum::NATIONAL_CONTEXT);

        $agencyRepoProphecy = $this->prophet->prophesize(AgencyRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($agencyRepoProphecy->reveal())
            ->shouldBeCalled();

        $this->tokenStorageProphecy
            ->getToken()
            ->willReturn($tokenProphecy->reveal())
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $agencyRepoProphecy
            ->findBy(['region' => '1'])
            ->willReturn($agencies)
            ->shouldBeCalled();

        $agenciesSent[] = $agencies[0];

        $this->agencyService->getAgenciesFromRegionSecured(1);

        $this->assertEquals($agencies[0], $agenciesSent[0]);
    }

    /**
     * testGetAgenciesFromRegionSecuredFail
     * @test
     * @group agencyService
     * @group services
     */
    public function testGetAgenciesFromRegionSecuredFail()
    {
        $agenciesSent = [];

        $agencies = [
            new Agency()
        ];

        $user = new User();
        $user->setTerritorialContext(null);

        $agencyRepoProphecy = $this->prophet->prophesize(AgencyRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($agencyRepoProphecy->reveal())
            ->shouldBeCalled();

        $this->tokenStorageProphecy
            ->getToken()
            ->willReturn($tokenProphecy->reveal())
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $tokenProphecy
            ->getUser()
            ->willReturn($user)
            ->shouldBeCalled();

        $agenciesSent[] = $agencies[0];

        $result = $this->agencyService->getAgenciesFromRegionSecured(1);

        $this->assertFalse($result);
    }

    /**
     * testGetAgenciesFromRegion
     * @test
     * @group agencyService
     * @group services
     */
    public function testGetAgenciesFromRegion()
    {
        $agenciesSent = [];

        $agencies = [
            new Agency()
        ];

        $agencyRepoProphecy = $this->prophet->prophesize(AgencyRepository::class);


        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($agencyRepoProphecy->reveal())
            ->shouldBeCalled();

        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($agencyRepoProphecy)
            ->shouldBeCalled();

        $agencyRepoProphecy
            ->findBy(['region' => '1'])
            ->willReturn($agencies)
            ->shouldBeCalled();

        $agenciesSent[] = $agencies[0];

        $this->agencyService->getAgenciesFromRegion(1);

        $this->assertEquals($agencies[0], $agenciesSent[0]);
    }
}
