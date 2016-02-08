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
            ->select('user.firstName, user.lastName, user.entity, user.username, role.label as userRole, agency.code as userAgency, user.enabled')
            ->leftJoin('user.role', 'role')
            ->leftJoin('user.agency', 'agency');

        $q = $qb->getQuery();

        return $q->getArrayResult();
    }

}