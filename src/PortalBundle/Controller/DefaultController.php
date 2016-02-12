<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Service\UserService;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class DefaultController
 * @package PortalBundle\Controller
 */
class DefaultController extends FOSRestController
{
    /**
     * @var UserService
     * @DI\Inject("portal.service.user")
     */
    protected $userService;
    /**
     * @var TokenStorage
     * @DI\Inject("security.token_storage")
     */
    protected $tokenStorage;

    /**
     * Fake Login
     * @Rest\Get("/fake/login/{userId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Login",
     *      resource = true,
     *      description = "Fake login"
     * )
     * @param $userId
     * @return \UserBundle\Entity\User
     */
    public function fakeLoginAction($userId)
    {
        $firewall = 'secured_area';
        $user = $this->userService->get($userId);
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $this->tokenStorage->setToken($token);
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * Fake Logout
     * @Rest\Get("/fake/logout")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Login",
     *      resource = true,
     *      description = "Fake logout"
     * )
     * @return \UserBundle\Entity\User
     */
    public function fakeLogoutAction()
    {
        $firewall = 'secured_area';
        $this->tokenStorage->setToken(new AnonymousToken($firewall, 'anon.'));
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * Who am I
     * @Rest\Get("/fake/whoami")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Login",
     *      resource = true,
     *      description = "Who am I"
     * )
     * @return \UserBundle\Entity\User
     */
    public function whoamiAction()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}