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
     * @Rest\Get("/regions/access")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Region",
     *      resource = true,
     *      description = "permet de récuperer le label dune region"
     * )
     */
    public function getAllAccessAction()
    {
        return $this->regionService->getRegionsAccess();
    }
}