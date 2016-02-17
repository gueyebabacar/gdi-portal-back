<?php

namespace PortalBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

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
     * @DI\Inject("security.authorization_checker")
     * @var AuthorizationChecker
     */
    public $authorizationChecker;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "authorizationChecker" = @DI\Inject("security.authorization_checker"),
     * })
     */
    public function __construct($em, $authorizationChecker)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Provide label from Region entity
     * @return array
     */
    public function getRegionsAccess()
    {
        $regionsSent = [];
        $regions = $this->em->getRepository('PortalBundle:Region')->findAll();
        foreach ($regions as $region) {
            if (false !== $this->authorizationChecker->isGranted('view', $region)) {
                $regionsSent[] = $region;
            }
        }
        return $regionsSent;
    }
}

