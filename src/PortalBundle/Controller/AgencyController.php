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
     * @Rest\Get("/agencies")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "Agency",
     *      resource = true,
     *      description = "permet de récuperer le label dune agence"
     * )
     */
    public function AgencyLabelAction()
    {
        return $this->agencyService->getAgencyLabel();
    }
}