<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use PortalBundle\Service\CurlService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Service\UserService;
use JMS\DiExtraBundle\Annotation as DI;

class ProxyController extends FOSRestController
{

    /**
     * @var UserService
     * @DI\Inject("portal.service.user")
     */
    protected $userService;

    /**
     * @var CurlService
     * @DI\Inject("portal.service.curl")
     */
    protected $curlService;

    /**
     * Redirection to GDI Intervenant
     * @Rest\Get("/api/gdii/{uri}", requirements={ "uri": "([a-z\.]{2,6})([\/\w \.-]*)*\/?$"})
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Redirect",
     *      resource = true,
     *      description = "Redirection to GDI Intervenant"
     * )
     * @param Request $request
     * @param $uri
     * @return string
     */
    public function redirectGdiAction(Request $request, $uri)
    {
//        $context = $this->get('security.token_storage');
//        $user = $context->getToken()->getUser();
        $baseUrl =  'http://10.0.55.2:8090/';
        $user = $this->get('doctrine.orm.entity_manager')->getRepository('UserBundle:User')->find(1);
        $profile = ['profile' => $this->userService->getProfile($user)];
        if ($user !== null) {
            return $this->curlService->sendRequest($request, $baseUrl.$uri, '');
        } else {
            return null;
        }
    }

    /**
     * Redirection to POP
     * @Rest\Get("/api/newppi/{uri}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Redirect",
     *      resource = true,
     *      description = "Redirection to POP"
     * )
     * @param $uri
     * @return string
     */
    public function redirectNewPpiAction($uri)
    {
        $context = $this->get('security.token_storage');
        if ($context->getToken()->getUser() !== null) {
            //TODO Redirection vers domain-newppi/api/$uri
            return $uri;
        } else {
            return null;
        }
    }
}