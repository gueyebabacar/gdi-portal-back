<?php

namespace TranscoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TranscoAgenceRepository
 * @package TranscoBundle\Repository
 * @DI\Service("service.transco.agence.repo", public=true)
 */
class TranscoAgenceRepository extends EntityRepository
{
    /**
     * @param $codeAgence
     * @return array
     */
    public function findPublicationOtRequest($codeAgence)
    {
        $qb = $this->createQueryBuilder('ta');
        $qb->select('ta.pr')
            ->where('ta.codeAgence = :codeAgence')
            ->setParameter('codeAgence', $codeAgence);

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param $destinataire
     * @param $center
     * @return array
     */
    public function findEnvoiDirgAgenceRequest($destinataire, $center)
    {
        $qb = $this->createQueryBuilder('ta');
        $qb->select('ta.codeAgence, ta.nni')
            ->where('ta.destinataire = :destinataire')
            ->andWhere('ta.center= :center')
            ->setParameter('destinataire', $destinataire)
            ->setParameter('center', $center);

        return $qb->getQuery()->getArrayResult();
    }
}