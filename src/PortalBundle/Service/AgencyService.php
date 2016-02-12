<?php

namespace PortalBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class AgencyService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.agency", public=true)
 */
class AgencyService
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Provide label from Agency entity
     * @return array
     */
    public function getAgencyLabel()
    {
        return $this->em->getRepository('PortalBundle:Agency')->findAll();
    }
}

