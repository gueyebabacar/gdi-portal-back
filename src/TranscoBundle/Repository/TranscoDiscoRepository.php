<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoDisco;

/**
 * Class TranscoDiscoRepository
 * @package TranscoBundle\Repository
 */
class TranscoDiscoRepository extends EntityRepository
{
    public function findEnvoiDirgDiscoRequest($criteria)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d.natOp, d.codeObject');
        foreach ($criteria as $item) {
            if ($item['name'] === TranscoDisco::CODE_NAT_INT) {
                $qb->andWhere('d.optic.codeNatInter = :codeNatInter')
                    ->setParameter('codeNatInter', $criteria['value']);
            }
            if ($item['name'] === TranscoDisco::CODE_FINALITE) {
                $qb->andWhere('d.optic.finalCode = :finalCode')
                    ->setParameter('finalCode', $criteria['value']);
            }
            if ($item['name'] === TranscoDisco::CODE_SEGMENTATION) {
                $qb->andWhere('d.optic.segmentationCode = :segmentationCode')
                    ->setParameter('segmentationCode', $criteria['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }
}