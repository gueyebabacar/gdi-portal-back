<?php

namespace PortalBundle\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class RequestFilterListener
{
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * @var Router
     */
    protected $router;

    public function __construct(TokenStorage $tokenStorage, Router $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->isXmlHttpRequest() && $this->tokenStorage->getToken() === null) {
            $event->stopPropagation();
            $event->setResponse(new JsonResponse(['user' => null]));
        }
        return;
    }
}