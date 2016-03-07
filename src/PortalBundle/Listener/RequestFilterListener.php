<?php

namespace PortalBundle\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
//use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestFilterListener
{
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
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