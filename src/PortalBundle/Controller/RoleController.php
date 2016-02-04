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

    /**
     * Creates a new Role".
     * @Rest\Post("/roles")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Role",
     *      resource = true,
     *      description = "Ajouter une ligne à la table Role"
     * )
     * @param Request $request
     * @return Role
     */
    public function createAction(Request $request)
    {
        return $this->roleService->create($request);
    }

    /**
     * Finds and displays a Role.
     * @Rest\Get("/roles/{id}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Role",
     *      resource = true,
     *      description = "Afficher une ligne de la table Role",
     *      parameters={
     *          {"name"="id", "dataType"="Integer", "required"=true, "description"="Id Role"},
     *      }
     * )
     * @param $id
     * @return Role
     */
    public function getAction($id)
    {
        return $this->roleService->get($id);
    }

    /**
     * Displays a form to edit an existing Role.
     * @Rest\Patch("/roles/{id}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Role",
     *      resource = true,
     *      description = "Editer une ligne de la table Role",
     *      parameters={
     *          {"name"="id", "dataType"="Integer", "required"=true, "description"="Id Role"},
     *      }
     * )
     * @param Request $request
     * @param $id
     * @return Role
     */
    public function editAction(Request $request, $id)
    {
        return $this->roleService->edit($request, $id);
    }

    /**
     * Deletes a Role.
     * @Rest\Delete("/roles/{id}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Role",
     *      resource = true,
     *      description = "Supprime une ligne de la table Role",
     *      parameters={
     *          {"name"="id", "dataType"="Integer", "required"=true, "description"="Id Role"},
     *      }
     * )
     * @param $id
     */
    public function deleteAction($id)
    {
        $this->roleService->delete($id);
    }
}
