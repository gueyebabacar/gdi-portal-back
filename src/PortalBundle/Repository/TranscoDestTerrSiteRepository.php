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


    /**
     * @param array $data
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findTerritoryFromAtg(array $data)
    {
        $qb = $this->createQueryBuilder("t");
        $qb->select("t.territory")
            ->where("t.idRefStructureOp = :idRefStructureOp")
            ->setParameter('idRefStructureOp', $data['criteria'][0]['value']);

        return $qb->getQuery()->getArrayResult();
    }


    /**
     * @param array $data
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public  function findAdresseeFromAtg(array $data)
    {
        $qb = $this->createQueryBuilder("t");
        $qb->select("t.adressee")
            ->where("t.idRefStructureOp = :idRefStructureOp")
            ->setParameter('idRefStructureOp', $data['criteria'][0]['value']);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public  function findPrFromAtg(array $data)
    {
        $qb = $this->createQueryBuilder("t");
        $qb->select("t.pr")
            ->where("t.idRefStructureOp = :idRefStructureOp")
            ->setParameter('idRefStructureOp', $data['criteria'][0]['value']);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public  function findAtgFromTerritory(array $data)
    {
        $qb = $this->createQueryBuilder("t");
        $qb->select("t.idRefStructureOp")
            ->where("t.territory = :territory")
            ->setParameter('territory', $data['criteria'][0]['value']);

        return $qb->getQuery()->getArrayResult();
    }


    /**
     * @param array $data
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public  function findAtgFromAdressee(array $data)
    {
        $qb = $this->createQueryBuilder("t");
        $qb->select("t.idRefStructureOp")
            ->where("t.adressee = :adressee")
            ->setParameter('adressee', $data['criteria'][0]['value']);

        return $qb->getQuery()->getArrayResult();
    }
}





