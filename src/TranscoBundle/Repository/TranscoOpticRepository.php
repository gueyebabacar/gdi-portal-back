<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 *
 * Class TranscoDiscoOpticRepository
 * @package TranscoBundle\Repository
 *
 * @DI\Service("service.optic.repository", public=true)
 */
class TranscoOpticRepository extends EntityRepository
{
    const TYPE_DE_TRAVAIL = "TypeDeTravail";
    const GROUPE_DE_GAMME = "GroupeDeGamme";
    const COMPTEUR = "Compteur";


    public function findDelegationOT(array $data)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');

        foreach ($data['criteria'] as $item) {
            if ($item['name'] === self::TYPE_DE_TRAVAIL) {
                $qb->andWhere('t.workType = :workType')
                    ->setParameter('workType', $item['value']);
            }
            if ($item['name'] === self::GROUPE_DE_GAMME) {
                $qb->andWhere('t.gammeGroup = :gammeGroup')
                    ->setParameter('gammeGroup', $item['value']);
            }
            if ($item['name'] === self::COMPTEUR) {
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
