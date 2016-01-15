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
    public function findPublicationOtRequest($criteria)
    {
        $qb = $this->createQueryBuilder('ta');
        $qb->select('ta.pr')
            ->where('ta.codeAgence = :codeAgence')
            ->setParameter('codeAgence', $criteria['value']);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param $criteria
     * @return array
     */
    public function findEnvoiDirgAgenceRequest($criteria)
    {
        $qb = $this->createQueryBuilder('ta');
        $qb->select('ta.codeAgence, ta.nni');
        foreach ($criteria as $item) {
        if ($item['name'] === TranscoAgence::CODE_AGENCE) {
                $qb->where('ta.destinataire = :destinataire')
                    ->setParameter('destinataire', $criteria['value']);
            }
            if ($item['name'] === TranscoAgence::CENTRE) {
                $qb->andWhere('ta.center= :center')
                    ->setParameter('center', $criteria['value']);
            }
        }
        return $qb->getQuery()->getArrayResult();
    }
}