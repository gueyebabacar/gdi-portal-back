<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends FOSRestController
{
    /**
     * Homepage
     * @Rest\Get("/")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Home",
     *      resource = true,
     *      description = "Homepage de portail"
     * )
     */
    public function indexAction()
    {
        return 'Bienvenue sur le Portail GDI';
    }
}