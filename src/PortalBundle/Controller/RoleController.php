<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use PortalBundle\Service\RoleService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Entity\Role;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Role controller
 * @RouteResource("Role")
 */
class RoleController extends FOSRestController
{

    /**
     * @var RoleService
     * @DI\Inject("portal.service.role")
     */
    protected $roleService;

    /**
     * Lists all Role.
     * @Rest\Get("/roles")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Role",
     *      resource = true,
     *      description = "Lister la table Role"
     * )
     */
    public function getAllAction()
    {
        return $this->roleService->getAll();
    }
}