<?php

namespace PortalBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TranscoNatureOpeRepository
 */
class TranscoNatureOpeRepository extends EntityRepository
{
    const TYPE_DE_TRAVAIL = "TypeDeTravail";
    const GROUPE_DE_GAMME = "GroupeDeGamme";
    const COMPTEUR = "Compteur";

    public function getCodeNatureIntervention3(array $data)
    {
        $qb = $this->createQueryBuilder('tno');
        $qb->select('tno.natureInterCode');
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

    public function getModeProgrammation(array $data)
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
