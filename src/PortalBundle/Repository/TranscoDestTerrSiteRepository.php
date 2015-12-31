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


    public  function findByTerritory($territory)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->where('t.territory = :territory')
            ->setParameter('territory', $territory);

        return $qb
            ->getQuery()
            ->getResult();
    }


    public  function findBySite($site)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->where('t.site = :site')
            ->setParameter('site', $site);

        return $qb
            ->getQuery()
            ->getResult();
    }

    public  function findByAdressee($adressee)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->where('t.adressee = :adressee')
            ->setParameter('adressee', $adressee);

        return $qb
            ->getQuery()
            ->getResult();
    }


    public  function findByPr($pr)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->where('t.pr = :pr')
            ->setParameter('pr', $pr);

        return $qb
            ->getQuery()
            ->getResult();
    }
}