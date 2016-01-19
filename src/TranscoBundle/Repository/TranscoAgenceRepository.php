<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoAgence;

/**
 * Class TranscoAgenceRepository
 * @package TranscoBundle\Repository
 */
class TranscoAgenceRepository extends EntityRepository
{
    /**
     * @param $criteria
     * @return array
     */
    public function findEnvoiDirgAgenceRequest($criteria)
    {
        $qb = $this->createQueryBuilder('ta');
        $qb->select('ta.destinataire, ta.center');
        foreach ($criteria as $item) {
            if ($item['name'] === TranscoAgence::CODE_AGENCE) {
                $qb->where('ta.codeAgence = :codeAgence')
                    ->setParameter('codeAgence', $item['value']);
            }
            if ($item['name'] === TranscoAgence::CODE_INSEE) {
                $qb->andWhere('ta.inseeCode = :inseeCode')
                    ->setParameter('inseeCode', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param $criteria
     * @return array
     */
    public function findPublicationOtRequest($criteria)
    {
        $qb = $this->createQueryBuilder('ta');
        $qb->select('ta.pr');

        foreach ($criteria as $item) {
            if ($item['name'] === TranscoAgence::CODE_AGENCE) {
                $qb->andWhere('ta.codeAgence = :codeAgence')
                    ->setParameter('codeAgence', $item['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }
}