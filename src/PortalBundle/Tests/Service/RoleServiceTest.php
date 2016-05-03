<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PortalBundle\Entity\Role;
use PortalBundle\Service\RoleService;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use UserBundle\Enum\RolesEnum;

class RoleServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    public $authorizationCheckerProphecy;

    /**
     * @var  RoleService
     */
    private $roleService;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

        $this->authorizationCheckerProphecy = $this->prophet->prophesize(AuthorizationCheckerInterface::class);

        /** @var AuthorizationChecker $authorizationChecker */
        $authorizationChecker = $this->authorizationCheckerProphecy->reveal();

        $this->roleService = new RoleService($authorizationChecker);
    }

    /**
     * testGetRoles
     * @test
     * @group roleService
     */
    public function testGetRoles()
    {
        $roles = $this->roleService->getRoles();
        $this->assertEquals(RolesEnum::ROLE_VISITEUR,$roles[0]);
        $this->assertEquals(RolesEnum::ROLE_TECHNICIEN,$roles[1]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR,$roles[2]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR_AVANCE,$roles[3]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_APPO,$roles[4]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_ATG,$roles[5]);
        $this->assertEquals(RolesEnum::ROLE_REFERENT_EQUIPE,$roles[6]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_LOCAL,$roles[7]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL,$roles[8]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_SI,$roles[9]);
    }

    /**
     * testGetRoleSecured
     * @test
     * @group roleService
     */
    public function testGetRoleSecured()
    {
        $roles = RolesEnum::getRoles();
        $rolesSent = [];
        foreach ($roles as $role) {
            $this->authorizationCheckerProphecy
                ->isGranted('view', $role)
                ->willReturn(true)
                ->shouldBeCalled();

            $rolesSent[] = $role;
        }
        $this->roleService->getRolesSecured();

        $this->assertEquals(RolesEnum::ROLE_VISITEUR , $rolesSent[0]);
        $this->assertEquals(RolesEnum::ROLE_TECHNICIEN , $rolesSent[1]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR , $rolesSent[2]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR_AVANCE , $rolesSent[3]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_APPO , $rolesSent[4]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_ATG , $rolesSent[5]);
        $this->assertEquals(RolesEnum::ROLE_REFERENT_EQUIPE , $rolesSent[6]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_LOCAL , $rolesSent[7]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL , $rolesSent[8]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_SI , $rolesSent[9]);
    }
}
