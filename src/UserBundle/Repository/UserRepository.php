<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
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