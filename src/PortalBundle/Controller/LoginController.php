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
        $user = null;
        if (in_array($this->get('kernel')->getEnvironment(), array('recette'), true)) {
            $user = ['user' => $this->tokenStorage->getToken()->getUser()];
        } else {
            /** @var User $user */
            $user = $this->userRepo->findOneByUsername('GAIA10');
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
            $this->tokenStorage->setToken($token);
            $user = ['user' => $this->tokenStorage->getToken()->getUser()];
        }

        return $user;
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