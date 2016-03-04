<?php

namespace PortalBundle\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class RequestFilterListener
{
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage) // this is @service_container
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->isXmlHttpRequest() && $this->tokenStorage->getToken() === null) {
            return new JsonResponse('caca');
        }
        return ;
    }
}