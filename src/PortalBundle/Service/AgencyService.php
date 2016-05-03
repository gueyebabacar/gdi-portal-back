<?php

namespace PortalBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Enum\VoterEnum;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use UserBundle\Entity\User;
use UserBundle\Enum\ContextEnum;

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
     * Return all agencies (secured)
     * @return array
     */
    public function getAgenciesFromRegionSecured($regionId)
    {
        $result = [];
        $agencyRepo = $this->em->getRepository('PortalBundle:Agency');

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        switch ($user->getTerritorialContext()) {
            case ContextEnum::AGENCY_CONTEXT:
                $result[] = $user->getAgency();
                break;

            case ContextEnum::REGION_CONTEXT:
                foreach ($user->getRegion()->getAgencies() as $agency) {
                    $result[] = $agency;
                }
                break;

            case ContextEnum::NATIONAL_CONTEXT:
                foreach ($agencyRepo->findBy(['region' => $regionId]) as $agency) {
                    $result[] = $agency;
                }
                break;

            default:
                return false;
                break;
        }
        return $result;
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

