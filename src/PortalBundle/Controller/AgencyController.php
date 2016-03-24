<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use PortalBundle\Service\AgencyService;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Agency controller
 * @RouteResource("Agency")
 */
class AgencyController
{
    /**
     * @var AgencyService
     * @DI\Inject("portal.service.agency")
     */
    protected $agencyService;

    /**
     * Provide Agency's label.
     * @Rest\Get("/regions/{regionId}/agencies_secured")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Agency",
     *      resource = true,
     *      description = "permet de récuperer le label dune agence (sécurisé)"
     * )
     * @param $regionId
     * @return array
     */
    public function getAgenciesFromRegionSecuredAction($regionId)
    {
        return $this->agencyService->getAgenciesFromRegionSecured($regionId);
    }

    /**
     * Provide Agency's label.
     * @Rest\Get("/regions/{regionId}/agencies")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Agency",
     *      resource = true,
     *      description = "permet de récuperer le label dune agence"
     * )
     * @param $regionId
     * @return array
     */
    public function getAgenciesFromRegionAction($regionId)
    {
        return $this->agencyService->getAgenciesFromRegion($regionId);
    }
}