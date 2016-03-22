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
    private $agencyService;

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

        $this->agencyService = new RoleService($authorizationChecker);
    }

    /**
     * testGetRoles
     */
    public function testGetRoles()
    {
        $roles = RolesEnum::getRoles();
        $this->assertEquals(RolesEnum::ROLE_VISITEUR_LABEL,$roles[RolesEnum::ROLE_VISITEUR]);
        $this->assertEquals(RolesEnum::ROLE_TECHNICIEN_LABEL,$roles[RolesEnum::ROLE_TECHNICIEN]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR_LABEL,$roles[RolesEnum::ROLE_PROGRAMMATEUR]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR_AVANCE_LABEL,$roles[RolesEnum::ROLE_PROGRAMMATEUR_AVANCE]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_APPO_LABEL,$roles[RolesEnum::ROLE_MANAGER_APPO]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_ATG_LABEL,$roles[RolesEnum::ROLE_MANAGER_ATG]);
        $this->assertEquals(RolesEnum::ROLE_REFERENT_EQUIPE_LABEL,$roles[RolesEnum::ROLE_REFERENT_EQUIPE]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_LOCAL_LABEL,$roles[RolesEnum::ROLE_ADMINISTRATEUR_LOCAL]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL_LABEL,$roles[RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_SI_LABEL,$roles[RolesEnum::ROLE_ADMINISTRATEUR_SI]);
    }

    /**
     * tesGetAgenciesFromRoleSecured
     */
    public function testGetRoleSecured()
    {
        $roles = RolesEnum::getRoles();
        $rolesSent = [];
        foreach ($roles as $role => $roleLabel) {
            $this->authorizationCheckerProphecy
                ->isGranted('view', $role)
                ->willReturn(true)
                ->shouldBeCalled();

            $rolesSent[] = [
                'label' => $roleLabel,
                'role' => $role
            ];
        }
        $this->agencyService->getRolesSecured();

        $this->assertEquals($roles[RolesEnum::ROLE_VISITEUR], $rolesSent[0]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_TECHNICIEN], $rolesSent[1]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_PROGRAMMATEUR], $rolesSent[2]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_PROGRAMMATEUR_AVANCE], $rolesSent[3]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_MANAGER_APPO], $rolesSent[4]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_MANAGER_ATG], $rolesSent[5]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_REFERENT_EQUIPE], $rolesSent[6]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_ADMINISTRATEUR_LOCAL], $rolesSent[7]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL], $rolesSent[8]['label']);
        $this->assertEquals($roles[RolesEnum::ROLE_ADMINISTRATEUR_SI], $rolesSent[9]['label']);
    }
}
