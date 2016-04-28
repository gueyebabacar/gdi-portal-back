<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Entity\User;
use UserBundle\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * User controller
 * @RouteResource("User")
 */
class UserController extends FOSRestController
{

    /**
     * @var UserService
     * @DI\Inject("portal.service.user")
     */
    protected $userService;

    /**
     * Lists all User entities.
     * @Rest\Get("/users")
     *
     * @Rest\View
     * @Security("has_role('ROLE_ADMINISTRATEUR_LOCAL')")
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Lister la table User"
     * )
     */
    public function getAllAction()
    {
        return $this->userService->getAll();
    }

    /**
     * Creates a new User entity.
     * @Rest\Post("/users")
     * @Security("has_role('ROLE_ADMINISTRATEUR_LOCAL')")
     * @Rest\View
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Ajouter une ligne à la table User"
     * )
     * @param Request $request
     * @return User
     */
    public function createAction(Request $request)
    {
        return $this->userService->create($request);
    }

    /**
     * Finds and displays a User entity.
     * @Rest\Get("/users/{userId}")
     *
     * @Rest\View
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Afficher une ligne de la table User",
     *      parameters={
     *          {"name"="userId", "dataType"="Integer", "required"=true, "description"="Id User"},
     *      }
     * )
     * @param $userId
     * @return User
     */
    public function getAction($userId)
    {
        return $this->userService->get($userId);
    }

    /**
     * Displays a form to edit an existing User entity.
     * @Rest\Patch("/users/{userId}")
     * @Security("has_role('ROLE_ADMINISTRATEUR_LOCAL')")
     * @Rest\View
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Editer une ligne de la table User",
     *      parameters={
     *          {"name"="userId", "dataType"="Integer", "required"=true, "description"="Id User"},
     *      }
     * )
     * @param Request $request
     * @param $userId
     * @return User
     */
    public function updateAction(Request $request, $userId)
    {
        return $this->userService->edit($request, $userId);
    }

    /**
     * Displays a form to edit the rights of an existing User (Disabled in prod env).
     * @Rest\Patch("/users/{userId}/rights")
     *
     * @Rest\View
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Editer le role et le contexte d'un user (Disabled in prod env)",
     *      parameters={
     *          {"name"="userId", "dataType"="Integer", "required"=true, "description"="Id User"},
     *      }
     * )
     * @param Request $request
     * @param $userId
     * @return User
     */
    public function updateRightsAction(Request $request, $userId)
    {
        if ($this->container->get('kernel')->getEnvironment() !== 'prod') {
            return $this->userService->updateRights($request, $userId);
        } else {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException(
                'This is not available on prod environment'
            );
        }
    }

    /**
     * Deletes a User entity.
     * @Rest\Delete("/users/{userId}")
     * @Security("has_role('ROLE_ADMINISTRATEUR_LOCAL')")
     * @Rest\View
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Supprime une ligne de la table User",
     *      parameters={
     *          {"name"="userId", "dataType"="Integer", "required"=true, "description"="Id User"},
     *      }
     * )
     * @param $userId
     */
    public function deleteAction($userId)
    {
        $this->userService->delete($userId);
    }

    /**
     * Lists all User profiles.
     * @Rest\Get("/profiles")
     *
     * @Rest\View
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Lister les differents profiles"
     * )
     */
    public function getProfilesAction()
    {
        return $this->userService->getProfiles();
    }

    /**
     * @Rest\Get("/userbygaia/{gaiaId}")
     * @Rest\View
     * @ApiDoc(
     *      section = "User",
     *      resource = true,
     *      description = "Recuperer un utilisateur par identifiant gaia",
     *      parameters={
     *          {"name"="gaiaId", "dataType"="String", "required"=true, "description"="identifiant gaia"},
     *      }
     * )
     * @param $gaiaId
     * @return array
     */
    public function getUserByGaiaAction($gaiaId)
    {
        return ['user' => $this->userService->getByIdGaia($gaiaId)];
    }
}