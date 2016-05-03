<?php

namespace PortalBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Enum\VoterEnum;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;

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
     * @DI\Inject("security.token_storage")
     * @var TokenStorage
     */
    public $tokenStorage;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     * @param $authorizationChecker
     *
     * @param $tokenStorage
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "authorizationChecker" = @DI\Inject("security.authorization_checker"),
     *     "tokenStorage" = @DI\Inject("security.token_storage")
     * })
     */
    public function __construct($em, $authorizationChecker, $tokenStorage)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Return all regions (secured)
     * @return array
     */
    public function getRegionsSecured()
    {
        $result = [];

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $regionRepo = $this->em->getRepository('PortalBundle:Region');

        switch ($user->getTerritorialContext()) {
            case ContextEnum::AGENCY_CONTEXT:
                $result[] = $user->getAgency()->getRegion();
                break;

            case ContextEnum::REGION_CONTEXT:
                $result[] = $user->getRegion();
                break;

            case ContextEnum::NATIONAL_CONTEXT:
                foreach ($regionRepo->findAll() as $region) {
                    $result[] = $region;
                }
                break;

            default:
                return false;
                break;
        }
        return $result;
    }

    /**
     * Return all regions
     * @return array
     */
    public function getRegions()
    {
        return $this->em->getRepository('PortalBundle:Region')->findAll();
    }
}

