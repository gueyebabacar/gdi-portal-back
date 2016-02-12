<?php

namespace PortalBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class RegionService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.region", public=true)
 */
class RegionService
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
     * Provide label from Region entity
     * @return array
     */
    public function getRegionLabel()
    {
        return $this->em->getRepository('PortalBundle:Region')->findAll();
    }
}

