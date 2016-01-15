<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TranscoDiscoRepository
 * @package TranscoBundle\Repository
 * @DI\Service("service.transco.disco.repo", public=true)
 */
class TranscoDiscoRepository extends EntityRepository
{
    public function findEnvoiDirgDiscoRequest($codeNatInter, $finalCode, $segmentationCode)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d.natOp, d.codeObject')
            ->where('d.optic.codeNatInter = :codeNatInter')
            ->andWhere('d.optic.finalCode = :finalCode')
            ->andWhere('d.optic.segmentationCode = :segmentationCode')
            ->setParameter('codeNatInter', $codeNatInter)
            ->setParameter('finalCode', $finalCode)
            ->setParameter('segmentationCode', $segmentationCode);

        return $qb->getQuery()->getArrayResult();
    }
}