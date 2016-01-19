<?php

namespace TranscoBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Repository\TranscoAgenceRepository;
use TranscoBundle\Repository\TranscoDiscoRepository;
use TranscoBundle\Repository\TranscoOpticRepository;
use TranscoBundle\Service\SoapService\ExposedWSService;

/**
 * Class TranscoService
 * @package TranscoBundle\Service
 *
 * @DI\Service("service.transco.transcoservice", public=true)
 */
class TranscoService
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @var TranscoDiscoRepository
     */
    public $transcoDiscoRepo;

    /**
     * @var TranscoOpticRepository
     */
    public $transcoOpticRepo;

    /**
     * @var TranscoAgenceRepository
     */
    public $transcoAgenceRepo;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     * })
     */
    public function __construct($em)
    {
        $this->em = $em;
        $this->transcoDiscoRepo = $em->getRepository('TranscoBundle:TranscoDisco');
        $this->transcoOpticRepo = $em->getRepository('TranscoBundle:TranscoOptic');
        $this->transcoAgenceRepo = $em->getRepository('TranscoBundle:TranscoAgence');
    }

    /**
     * @param $criteria
     * @return array|mixed
     */
    public function getDelegationBiResponse($criteria)
    {
        $return = [];
        $result = $this->transcoOpticRepo->findDelegationBI($criteria);
        if (empty($result)) {
            return ExposedWSService::ERROR_NOT_FOUND;
        } elseif (sizeof($result) !== 1 && sizeof($result[0]) != 4) {
            return ExposedWSService::ERROR_IMPOSSIBLE_TRANSCODIFICATION;
        }
        foreach ($result[0] as $key => $item) {
            if ($key === "codeNatInter") {
                $return[] = ['NomCritere' => TranscoOptic::CODE_NAT_INT, 'ValeurCritere' => $item];
            }
            if ($key === 'finalCode') {
                $return[] = ['NomCritere' => TranscoOptic::CODE_FINALITE, 'ValeurCritere' => $item];
            }
            if ($key === 'segmentationCode') {
                $return[] = ['NomCritere' => TranscoOptic::CODE_SEGMENTATION, 'ValeurCritere' => $item];
            }
            if ($key === 'programmingMode') {
                $return[] = ['NomCritere' => TranscoOptic::PROGRAMMING_MODE, 'ValeurCritere' => $item];
            }
        }
        return $return;
    }

    /**
     * @param $criteria
     * @return array|mixed
     */
    public function getDelegationOtResponse($criteria)
    {
        $return = [];
        $result = $this->transcoOpticRepo->findDelegationOT($criteria);
        if (empty($result)) {
            return ExposedWSService::ERROR_NOT_FOUND;
        } elseif (sizeof($result) !== 1) {
            return ExposedWSService::ERROR_IMPOSSIBLE_TRANSCODIFICATION;
        }
        foreach ($result[0] as $key => $item) {
            if ($key === "codeNatInter") {
                $return[] = ['NomCritere' => TranscoOptic::CODE_NAT_INT, 'ValeurCritere' => $item];
            }
            if ($key === 'finalCode') {
                $return[] = ['NomCritere' => TranscoOptic::CODE_FINALITE, 'ValeurCritere' => $item];
            }
            if ($key === 'segmentationCode') {
                $return[] = ['NomCritere' => TranscoOptic::CODE_SEGMENTATION, 'ValeurCritere' => $item];
            }
            if ($key === 'programmingMode') {
                $return[] = ['NomCritere' => TranscoOptic::PROGRAMMING_MODE, 'ValeurCritere' => $item];
            }
        }

        return $return;
    }

    /**
     * @param $criteria
     * @return mixed
     */
    public function getEnvoiDirgtResponse($criteria)
    {
        $return = [];
        $discoResult = $this->transcoDiscoRepo->findEnvoiDirgDiscoRequest($criteria);

        if (empty($discoResult)) {
            return ExposedWSService::ERROR_NOT_FOUND;
        } elseif (sizeof($discoResult) !== 1 ) {
            return ExposedWSService::ERROR_IMPOSSIBLE_TRANSCODIFICATION;
        }
        foreach ($discoResult[0] as $key => $item) {
            if ($key === "natOp") {
                $return[] = ['NomCritere' => TranscoDisco::CODE_NAT_OP, 'ValeurCritere' => $item];
            }
            if ($key === 'codeObject') {
                $return[] = ['NomCritere' => TranscoDisco::CODE_OBJECT, 'ValeurCritere' => $item];
            }
        }

        $agenceResult = $this->transcoAgenceRepo->findEnvoiDirgAgenceRequest($criteria);
        if (empty($agenceResult)) {
            return ExposedWSService::ERROR_NOT_FOUND;
        } elseif (sizeof($agenceResult) !== 1 ) {
            return ExposedWSService::ERROR_IMPOSSIBLE_TRANSCODIFICATION;
        }

        foreach ($agenceResult[0] as $key => $item) {
            if ($key === "destinataire") {
                $return[] = ['NomCritere' => TranscoAgence::DESTINATAIRE, 'ValeurCritere' => $item];
            }
            if ($key === 'center') {
                $return[] = ['NomCritere' => TranscoAgence::CENTRE, 'ValeurCritere' => $item];
            }
        }
        if (sizeof($return) != 4) {
            return ExposedWSService::ERROR_NOT_FOUND;
        }
        return $return;
    }

    /**
     * @param $criteria
     * @return array|mixed
     */
    public function getPublicationOttResponse($criteria)
    {
        $return = [];
        $result = $this->transcoAgenceRepo->findPublicationOtRequest($criteria);

        if (empty($result)) {
            return ExposedWSService::ERROR_NOT_FOUND;
        } elseif (sizeof($result) !== 1) {
            return ExposedWSService::ERROR_IMPOSSIBLE_TRANSCODIFICATION;
        }
        foreach ($result[0] as $key => $item) {
            if ($key === "pr") {
                $return[] = ['NomCritere' => TranscoAgence::PR, 'ValeurCritere' => $item];
            }
        }
        return $return;
    }
}

