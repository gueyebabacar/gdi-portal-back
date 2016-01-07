<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use TranscoBundle\Service\SoapService\ExposedWSService;

class TranscoDestTerrSiteRepository extends EntityRepository
{

    public function findByIdRefOp($idRefStructureOp)
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
    public function findAdresseeFromAtg(array $data)
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
    public function findPrFromAtg(array $data)
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
    public function findAtgFromTerritoryOrAdressee(array $data)
    {
        $qb = $this->createQueryBuilder("t");
        $qb->select("t.idRefStructureOp");
        if($data['criteria'][0]['name'] === ExposedWSService::TERRITORY){
            $qb->andWhere("t.territory = :territory")
                ->setParameter('territory', $data['criteria'][0]['value']);
        } elseif($data['criteria'][0]['name'] === ExposedWSService::ADRESSEE){
            $qb->andWhere("t.adressee = :addressee")
            ->setParameter('addressee', $data['criteria'][0]['value']);
        }

        return $qb->getQuery()->getArrayResult();
    }
}





