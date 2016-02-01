<?php

namespace PortalBundle\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class RequestListener
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var TokenStorage
     */
    protected $context;

    public function __construct(Router $router, TokenStorage $context)
    {
        $this->router = $router;
        $this->context = $context;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($this->context->getToken()->getUser() !== "anon.") {
            dump($this->context->getToken()->getUser());
            $exception = $event->getException();
            if (is_a($exception, 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException')) {
                /** @var Request $request */
                $request = $event->getRequest();
                if ($request->getPathInfo() === '/api/gdii') {
//                $event->setResponse(new RedirectResponse($this->router->generate('nelmio_api_doc_index')));
                    exit;
                }
            }
        }

    }
}