<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TranscoDiscOpticGmaoRepository
 */
class TranscoDiscOpticGmaoRepository extends EntityRepository
{
    const CODE_NAT_INTER = "CodeNatureIntervention";
    const FINAL_CODE  = "CodeFinalite";
    const SEGMENTATION_CODE = "CodeSegmentation";
    const PROGRAMMING_MODE = "ModeProgrammation";

    public function findCdNatIntrCdFinalCdSegProgMod(array $data)
    {
        $qb = $this->createQueryBuilder('tdg');
        $qb->select('tdg.codeNatInter, tdg.finalCode, tdg.segmentationCode, tdg.programmingMode');
        foreach ($data['criteria'] as $item) {
            if ($item['name'] === self::CODE_NAT_INTER) {
                $qb->andWhere('tdg.workType = :workType')
                    ->setParameter('workType', $item['value']);
            }
            if ($item['name'] === self::FINAL_CODE) {
                $qb->andWhere('tdg.gammeGroup = :gammeGroup')
                    ->setParameter('gammeGroup', $item['value']);
            }
            if ($item['name'] === self::SEGMENTATION_CODE) {
                $qb->andWhere('tdg.counter = :counter')
                    ->setParameter('counter', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }

    public function findModeProgrammation(array $data)
    {
        $qb = $this->createQueryBuilder('tno');
        $qb->select('tno.programmingMode');
        foreach ($data['criteria'] as $item) {
            if ($item['name'] === self::TYPE_DE_TRAVAIL) {
                $qb->andWhere('tno.workType = :workType')
                    ->setParameter('workType', $item['value']);
            }
            if ($item['name'] === self::GROUPE_DE_GAMME) {
                $qb->andWhere('tno.gammeGroup = :gammeGroup')
                    ->setParameter('gammeGroup', $item['value']);
            }
            if ($item['name'] === self::COMPTEUR) {
                $qb->andWhere('tno.counter = :counter')
                    ->setParameter('counter', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }
}
