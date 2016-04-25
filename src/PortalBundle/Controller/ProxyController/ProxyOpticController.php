<?php

namespace PortalBundle\Controller\ProxyController;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use PortalBundle\Service\CurlService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use UserBundle\Service\UserService;
use JMS\DiExtraBundle\Annotation as DI;

class ProxyOpticController extends FOSRestController
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
     * @var TokenStorage
     * @DI\Inject("security.token_storage")
     */
    protected $security;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * ProxyOpticController constructor.
     *
     * @param $userService
     * @param $curlService
     * @param $security
     * @DI\InjectParams({
     *     "userService" = @DI\Inject("portal.service.user"),
     *     "curlService" = @DI\Inject("portal.service.curl"),
     *     "security" = @DI\Inject("security.token_storage"),
     * })
     */
    public function __construct($userService, $curlService, $security)
    {
        $this->userService = $userService;
        $this->curlService = $curlService;
        $this->security = $security;
    }

    /**
     * @Rest\Get("/optic/{uri}", requirements={ "uri": "([a-z\.]{2,6})([\/\w \.-]*)*\/?$"})
     * @Rest\View
     * @ApiDoc(
     *      section = "ProxyController",
     *      resource = true,
     *      description = "Redirection to Optic"
     * )
     * @param Request $request
     * @param $uri
     * @return string
     */
    public function redirectGetOpticAction(Request $request, $uri)
    {
        return $this->forwardRequest($request, $uri);
    }

    /**
     * @Rest\Post("/optic/{uri}", requirements={ "uri": "([a-z\.]{2,6})([\/\w \.-]*)*\/?$"})
     * @Rest\View
     * @ApiDoc(
     *      section = "ProxyController",
     *      resource = true,
     *      description = "Redirection to Optic"
     * )
     * @param Request $request
     * @param $uri
     * @return string
     */
    public function redirectPostOpticAction(Request $request, $uri)
    {
        return $this->forwardRequest($request, $uri);
    }

    /**
     * @Rest\Put("/optic/{uri}", requirements={ "uri": "([a-z\.]{2,6})([\/\w \.-]*)*\/?$"})
     * @Rest\View
     * @ApiDoc(
     *      section = "ProxyController",
     *      resource = true,
     *      description = "Redirection to Optic"
     * )
     * @param Request $request
     * @param $uri
     * @return string
     */
    public function redirectPutOpticAction(Request $request, $uri)
    {
        return $this->forwardRequest($request, $uri);
    }

    /**
     * @Rest\Delete("/optic/{uri}", requirements={ "uri": "([a-z\.]{2,6})([\/\w \.-]*)*\/?$"})
     * @Rest\View
     * @ApiDoc(
     *      section = "ProxyController",
     *      resource = true,
     *      description = "Redirection to Optic"
     * )
     * @param Request $request
     * @param $uri
     * @return string
     */
    public function redirectDeleteOpticAction(Request $request, $uri)
    {
        return $this->forwardRequest($request, $uri);
    }

    /**
     * @return mixed
     */
    private function getCurrentUser()
    {
        return $this->getUser();
    }

    /**
     * @param Request $request
     * @param $uri
     * @return mixed|null
     */
    private function forwardRequest(Request $request, $uri)
    {
        $user = $this->getCurrentUser();

        $this->baseUrl = $this->getParameter('optic_url');
        $queryParameters = $request->getQueryString();
        $url = $this->baseUrl . $uri;
        if ($queryParameters != null) {
            $url .= '?' . $queryParameters;
        }

        $parameters['headers'] = [
            'x-profil' => json_encode($this->userService->getProfile($user)),
        ];
        $parameters['parameters'] = json_encode($request->request->all());
        if ($user !== null) {
            $data = $this->curlService->sendRequest($url, $parameters);
            return new Response($data['contents'], $data['code']);
        } else {
            return null;
        }
    }
}