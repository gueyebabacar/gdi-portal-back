<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package UserBundle\Repository
 */
class UserRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getUserAttributes()
    {
        $qb = $this->createQueryBuilder('user');
        $qb
            ->select('user.firstName, user.firstName, user.lastName, user.entity, user.username, user.roles, userAgency.label as agency, user.enabled, userRegion.label as region')
            ->leftJoin('user.agency', 'userAgency')
            ->leftJoin('user.region', 'userRegion');

        $q = $qb->getQuery();

        return $q->getArrayResult();
    }

    /**
     * @return array
     */
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