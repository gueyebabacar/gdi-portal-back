<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoOptic;

/**
 * Class TranscoDiscoRepository
 * @package TranscoBundle\Repository
 */
class TranscoDiscoRepository extends EntityRepository
{
    public function findEnvoiDirgDiscoRequest($criteria)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d.natOp, d.codeObject')
            ->leftJoin('d.optic', 'optic');
        foreach ($criteria as $item) {
            if ($item['name'] === TranscoOptic::CODE_NAT_INT) {
                $qb->andWhere('optic.codeNatInter = :codeNatInter')
                    ->setParameter('codeNatInter', $item['value']);
            }
            if ($item['name'] === TranscoOptic::CODE_FINALITE) {
                $qb->andWhere('optic.finalCode = :finalCode')
                    ->setParameter('finalCode', $item['value']);
            }
            if ($item['name'] === TranscoOptic::CODE_SEGMENTATION) {
                $qb->andWhere('optic.segmentationCode = :segmentationCode')
                    ->setParameter('segmentationCode', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }
}