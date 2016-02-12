<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package UserBundle\Repository
 */
class UserRepository extends EntityRepository
{
    public function getUserAttributes()
    {
        $qb = $this->createQueryBuilder('user');
        $qb
            ->select('user.firstName, user.lastName, user.entity, user.username, user.roles, agency.label as userAgency, user.enabled, region.label as userRegion')
            ->leftJoin('user.agency', 'agency')
            ->leftJoin('user.region', 'region');

        $q = $qb->getQuery();

        return $q->getArrayResult();
    }

    public function getProfiles()
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('user.id, user.firstName, user.lastName, user.entity, user.username, user.roles, userAgency.label as agency, user.enabled, userRegion.label as region')
            ->leftJoin('user.agency', 'userAgency')
            ->leftJoin('user.region', 'userRegion')
            ->distinct('user.roles');
        return $qb->getQuery()->getArrayResult();
    }
}