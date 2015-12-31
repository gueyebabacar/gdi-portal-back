<?php

namespace PortalBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TranscoDestTerrSiteRepository extends EntityRepository
{

    public  function findByIdRefOp($idRefStructureOp)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->where('t.idRefStructureOp = :idRefStructureOp')
            ->setParameter('idRefStructureOp', $idRefStructureOp);

        return $qb
            ->getQuery()
            ->getResult();
    }

}