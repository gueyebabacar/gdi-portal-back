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
    // GMAO constant
    const TYPE_DE_TRAVAIL = "TypeDeTravail";
    const GROUPE_DE_GAMME = "GroupeDeGamme";
    const COMPTEUR = "Compteur";

    // Disco Constant
    const CODE_NAT_Op = "CodeNatureOperation";
    const CODE_OBJECT = "CodeObjet";



    public function findDelegationOT(array $data)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');
        $qb->leftJoin('t.gmao', 'gmao')
            ->addSelect('gmao');

        foreach ($data['criteria'] as $item) {
            if ($item['name'] === self::TYPE_DE_TRAVAIL) {
                $qb->andWhere('gmao.workType = :workType')
                    ->setParameter('workType', $item['value']);
            }
            if ($item['name'] === self::GROUPE_DE_GAMME) {
                $qb->andWhere('gmao.gammeGroup = :gammeGroup')
                    ->setParameter('gammeGroup', $item['value']);
            }
            if ($item['name'] === self::COMPTEUR) {
                $qb->andWhere('gmao.counter = :counter')
                    ->setParameter('counter', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }


    public function findDelegationBI(array $data)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->leftJoin('t.disco', 'disco')
            ->addSelect('disco');
        $qb->select('t.codeNatInter, t.finalCode, t.segmentationCode, t.programmingMode');

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
