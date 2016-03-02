<?php

namespace PortalBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Enum\VoterEnum;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use UserBundle\Enum\RolesEnum;

/**
 * Class RolService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.role", public=true)
 */
class RoleService
{
    /**
     * @DI\Inject("security.authorization_checker")
     * @var AuthorizationChecker
     */
    public $authorizationChecker;

    /**
     * ControlService constructor.
     * @param $authorizationChecker
     *
     * @DI\InjectParams({
     *     "authorizationChecker" = @DI\Inject("security.authorization_checker"),
     * })
     */
    public function __construct($authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Lists all Roles.
     */
    public function getRoles()
    {
        return RolesEnum::getRoles();
    }

    /**
     * Lists all Roles (secured).
     */
    public function getRolesSecured()
    {
        $rolesSent = [];
        $roles = RolesEnum::getRoles();
        foreach ($roles as $role => $roleLabel) {
            if (false !== $this->authorizationChecker->isGranted(VoterEnum::VIEW, $role)) {
                $rolesSent[] = [$role
//                    'label' => $roleLabel,
//                    'role' => $role
                ];
            }
        }
        return $rolesSent;
    }
}
