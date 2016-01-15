<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoOptic;

/**
 * Class TranscoDiscoOpticRepository
 * @package TranscoBundle\Repository
 */
class TranscoOpticRepository extends EntityRepository
{
    // Disco Constant
    const CODE_NAT_Op = "CodeNatureOperation";
    const CODE_OBJECT = "CodeObjet";

    public function findDelegationOT(array $criteria)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');
        $qb->leftJoin('t.gmao', 'gmao');

        foreach ($criteria as $item) {
            if ($item['name'] === TranscoOptic::TYPE_DE_TRAVAIL) {
                $qb->andWhere('t.workType = :workType')
                    ->setParameter('workType', $item['value']);
            }
            if ($item['name'] === TranscoOptic::GROUPE_DE_GAMME) {
                $qb->andWhere('t.gammeGroup = :gammeGroup')
                    ->setParameter('gammeGroup', $item['value']);
            }
            if ($item['name'] === TranscoOptic::COMPTEUR) {
                $qb->andWhere('t.counter = :counter')
                    ->setParameter('counter', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }


    public function findDelegationBI(array $data)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');
        $qb->leftJoin('t.disco', 'disco')
            ->addSelect('disco');

        foreach ($data['criteria'] as $item) {
            if ($item['name'] === self::CODE_NAT_Op) {
                $qb->andWhere('disco.natOp = :natOp')
                    ->setParameter('natOp', $item['value']);
            }
            if ($item['name'] === self::CODE_OBJECT) {
                $qb->andWhere('disco.codeObject = :codeObject')
                    ->setParameter('codeObject', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }


}
