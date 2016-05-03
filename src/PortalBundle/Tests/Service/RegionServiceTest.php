<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Repository\RegionRepository;
use PortalBundle\Service\RegionService;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;

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
     * @var ObjectProphecy
     */
    public $tokenStorageProphecy;

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

        $this->tokenStorageProphecy = $this->prophet->prophesize(TokenStorage::class);

        /** @var TokenStorage $tokenStorage */
        $tokenStorage = $this->tokenStorageProphecy->reveal();

        $this->agencyService = new RegionService($em, $authorizationChecker, $tokenStorage);
    }

    /**
     * testgetRegionsSecuredAgencyContext
     * @test
     * @group regionService
     */
    public function testgetRegionsSecuredAgencyContext()
    {
        $user = new User();
        $user->setTerritorialContext(ContextEnum::AGENCY_CONTEXT);

        $agency = new Agency();

        $region = new Region();
        $region->addAgency($agency);

        $user->setAgency($agency);

        $regionRepoProphecy = $this->prophet->prophesize(RegionRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Region")
            ->willReturn($regionRepoProphecy->reveal())
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


        $this->agencyService->getRegionsSecured();
    }

    /**
     * testGetAgenciesFromRegionSecuredRegionContext
     * @test
     * @group regionService
     */
    public function testGetRegionsFromRegionSecuredRegionContext()
    {

        $user = new User();
        $user->setTerritorialContext(ContextEnum::REGION_CONTEXT);
        $region = new Region();
        $region->addAgency(new Agency());
        $user->setRegion($region);

        $regionRepoProphecy = $this->prophet->prophesize(RegionRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Region")
            ->willReturn($regionRepoProphecy->reveal())
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

        $this->agencyService->getRegionsSecured();
    }

    /**
     * testGetRegionsFromRegionSecuredNationalContext
     * @test
     * @group regionService
     */
    public function testGetRegionsFromRegionSecuredNationalContext()
    {
        $user = new User();
        $user->setTerritorialContext(ContextEnum::NATIONAL_CONTEXT);

        $regionRepoProphecy = $this->prophet->prophesize(RegionRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Region")
            ->willReturn($regionRepoProphecy->reveal())
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

        $regionRepoProphecy
            ->findAll()
            ->willReturn([new Region()])
            ->shouldBeCalled();

        $this->agencyService->getRegionsSecured();
    }

    /**
     * testGetRegionsFromRegionSecuredFail
     * @test
     * @group regionService
     */
    public function testGetRegionsFromRegionSecuredFail()
    {

        $user = new User();
        $user->setTerritorialContext(null);

        $regionRepoProphecy = $this->prophet->prophesize(RegionRepository::class);

        $tokenProphecy = $this->prophet->prophesize(TokenInterface::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Region")
            ->willReturn($regionRepoProphecy->reveal())
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


        $result = $this->agencyService->getRegionsSecured();

        $this->assertFalse($result);
    }

    /**
     * testGetRegions
     * @test
     * @group regionService
     */
    public function testGetRegions()
    {
        $regionRepoProphecy = $this->prophet->prophesize(RegionRepository::class);

        $this->emProphecy
            ->getRepository("PortalBundle:Region")
            ->willReturn($regionRepoProphecy->reveal())
            ->shouldBeCalled();

        $regionRepoProphecy
            ->findAll()
            ->willReturn([new Region()])
            ->shouldBeCalled();

        $this->agencyService->getRegions(1);
    }
}
