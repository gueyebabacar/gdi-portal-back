<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
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
        if($this->tokenStorage->getToken() == null){
            return $this->redirectToRoute('is_logged');
        }
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * Who am I
     * @Rest\Get("/user/logged")
     * @Rest\View
     *
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