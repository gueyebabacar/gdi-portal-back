<?php

namespace PortalBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TranscoNatureInterRepository
 */
class TranscoNatureInterRepository extends EntityRepository
{
    /**
     * @param array $data
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCodeNatIntFromCodeNatOp(array $data)
    {
        $qb = $this->createQueryBuilder("tni");
        $qb->select("tni.opticNatCode")
            ->where("tni.pictrelNatOpCode = :natOp")
            ->setParameter('natOp', $data['criteria'][0]['value']);
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCodeNatopFromCodeNatInt(array $data)
    {
        $qb = $this->createQueryBuilder("tni");
        $qb->select("tni.pictrelNatOpCode")
            ->where("tni.opticNatCode = :natInt")
            ->setParameter('natInt', $data['criteria'][0]['value']);

        return $qb->getQuery()->getArrayResult();
    }


}
