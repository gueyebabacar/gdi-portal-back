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
     * @param null $userId
     * @return array
     */
    public function getUserAttributes($userId = null)
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('user, agency, region')
            ->leftJoin('user.agency', 'agency')
            ->leftJoin('user.region', 'region');
        if ($userId != null) {
            $qb->where('user.id = :userId')
                ->setParameter('userId', $userId);
        }
        $q = $qb->getQuery();

        return $q->getArrayResult();
    }
    /**
     * @return array
     */
    public function getProfiles()
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('user.id, user.firstName, user.lastName, user.entity, user.username, user.territorialContext, user.territorialCode, user.roles, userAgency.label as agency, user.enabled, userRegion.label as region')
            ->leftJoin('user.agency', 'userAgency')
            ->leftJoin('user.region', 'userRegion')
            ->where('user.username LIKE :username')
            ->setParameter('username', 'GAIA%');
        return $qb->getQuery()->getArrayResult();
    }
}