<?php

namespace PortalBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Enum\VoterEnum;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

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
     * @DI\Inject("security.authorization_checker")
     * @var AuthorizationChecker
     */
    public $authorizationChecker;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     * @param $authorizationChecker
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
     * Return all agencies (secured)
     * @param $regionId
     * @return array
     */
    public function getAgenciesFromRegionSecured($regionId)
    {
        $agenciesSent = [];
        $agencyRepo = $this->em->getRepository('PortalBundle:Agency');
        $agencies = $agencyRepo->findBy(['region' => $regionId]);
        foreach ($agencies as $agency) {
            if (false !== $this->authorizationChecker->isGranted(VoterEnum::VIEW, $agency)) {
                $agenciesSent[] = $agency;
            }
        }
        return $agenciesSent;
    }

    /**
     * Return all agencies (secured)
     * @param $regionId
     * @return array
     */
    public function getAgenciesFromRegion($regionId)
    {
        $agencyRepo = $this->em->getRepository('PortalBundle:Agency');
        return $agencyRepo->findBy(['region' => $regionId]);
    }
}

