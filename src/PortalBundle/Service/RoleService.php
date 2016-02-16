<?php

namespace PortalBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;
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
     * Lists all Roles.
     */
    public function getAll()
    {
        return RolesEnum::getRoles();
    }
}
