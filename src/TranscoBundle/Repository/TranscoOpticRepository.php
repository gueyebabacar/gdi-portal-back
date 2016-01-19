<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoGmao;

/**
 * Class TranscoOpticRepository
 * @package TranscoBundle\Repository
 */
class TranscoOpticRepository extends EntityRepository
{
    public function findDelegationOT(array $criteria)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');
        $qb->leftJoin('t.gmaos', 'gmao');

        foreach ($criteria as $item) {
            if ($item['name'] === TranscoGmao::TYPE_DE_TRAVAIL) {
                $qb->andWhere('gmao.workType = :workType')
                    ->setParameter('workType', $item['value']);
            }
            if ($item['name'] === TranscoGmao::GROUPE_DE_GAMME) {
                $qb->andWhere('gmao.groupGame = :groupGame')
                    ->setParameter('groupGame', $item['value']);
            }
            if ($item['name'] === TranscoGmao::COMPTEUR) {
                $qb->andWhere('gmao.counter = :counter')
                    ->setParameter('counter', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }


    public function findDelegationBI(array $criteria)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');
        $qb->leftJoin('t.disco', 'disco');

        foreach ($criteria as $item) {
            if ($item['name'] === TranscoDisco::CODE_NAT_OP) {
                $qb->andWhere('disco.natOp = :natOp')
                    ->setParameter('natOp', $item['value']);
            }
            if ($item['name'] === TranscoDisco::CODE_OBJECT) {
                $qb->andWhere('disco.codeObject = :codeObject')
                    ->setParameter('codeObject', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }
}
