<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use PortalBundle\Service\RegionService;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Region controller
 * @RouteResource("Region")
 */
class RegionController
{
    /**
     * @var RegionService
     * @DI\Inject("portal.service.region")
     */
    protected $regionService;

    /**
     * Provide Region's label.
     * @Rest\Get("/regions_secured")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Region",
     *      resource = true,
     *      description = "Permet de récuperer les régions (sécurisé)"
     * )
     */
    public function getAllRegionsSecuredAction()
    {
        return $this->regionService->getRegionsSecured();
    }

    /**
     * Provide Region's label.
     * @Rest\Get("/regions")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Region",
     *      resource = true,
     *      description = "Permet de récuperer les régions"
     * )
     */
    public function getAllRegionsAction()
    {
        return $this->regionService->getRegions();
    }
}