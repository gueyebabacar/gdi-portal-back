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
            ->select('user.firstName, user.lastName, user.entity, user.username, user.roles, userAgency.label as agency, user.enabled, userRegion.label as region, user.id')
            ->leftJoin('user.agency', 'userAgency')
            ->leftJoin('user.region', 'userRegion');

        $q = $qb->getQuery();

        return $q->getArrayResult();
    }

}