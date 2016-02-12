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

}