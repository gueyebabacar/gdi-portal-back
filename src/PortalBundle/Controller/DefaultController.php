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
     * @var TokenStorage
     * @DI\Inject("security.token_storage")
     */
    protected $tokenStorage;

    /**
     * Who am I
     * @Rest\Get("/user/whoami")
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