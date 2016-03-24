<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;
use UserBundle\Service\UserService;

/**
 * Class DefaultController
 *
 * @package PortalBundle\Controller
 */
class LoginController extends FOSRestController
{

    /**
     * @var TokenStorage
     * @DI\Inject("security.token_storage")
     */
    protected $tokenStorage;

    /**
     * @var UserRepository
     * @DI\Inject("portal.user_repository")
     */
    protected $userRepo;

    /**
     * @var UserService
     * @DI\Inject("portal.service.user")
     */
    protected $userService;

    /**
     * Who am I
     * @Rest\Get("/user/whoami")
     *
     * @Rest\View
     * @ApiDoc(
     *      section = "Login",
     *      resource = true,
     *      description = "Who am I"
     * )
     * @return \UserBundle\Entity\User
     */
    public function whoAmIAction()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        return ['user' => $this->userService->get($user->getId())];
    }

    /**
     * Logged
     * @Rest\Get("/user/logged")
     *
     * @Rest\View
     * @ApiDoc(
     *      section = "Login",
     *      resource = true,
     *      description = "Is logged"
     * )
     * @return JsonResponse|RedirectResponse
     * @internal param Request $request
     */
    public function isLoggedAction()
    {
        return $this->redirect('/', 301);
    }

}