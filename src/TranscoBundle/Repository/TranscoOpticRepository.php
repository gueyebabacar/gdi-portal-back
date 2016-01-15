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

    public function findDelegationOT(array $criteria)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');

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

    }


}
