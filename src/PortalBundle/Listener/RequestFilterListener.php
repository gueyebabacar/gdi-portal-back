<?php

namespace PortalBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
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
        if($request->get('_route') === 'is_not_logged'){
            return;
        }
        if ($request->isXmlHttpRequest() && $this->tokenStorage->getToken() === null) {
            $event->setResponse(new RedirectResponse('/api' . $this->router->generate('is_not_logged')));
        }
        return;
    }
}