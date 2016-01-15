<?php

namespace TranscoBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Repository\TranscoAgenceRepository;
use TranscoBundle\Repository\TranscoDiscoRepository;
use TranscoBundle\Repository\TranscoOpticRepository;

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

    public function getDelegationBiResponse($criteria)
    {
        $response = $this->transcoOpticRepo->findDelegationBI($criteria);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    public function getDelegationOttResponse($criteria)
    {
        $response = $this->transcoOpticRepo->findDelegationOT($criteria);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    public function getEnvoiDirgtResponse($criteria)
    {
        $response = [];
        $discoResponse = $this->transcoDiscoRepo->findEnvoiDirgDiscoRequest($criteria);
        if(sizeof($discoResponse) !== 1){
            array_merge($response, $discoResponse);
        }
        $agenceResponse = $this->transcoAgenceRepo->findEnvoiDirgAgenceRequest($criteria);
        if(sizeof($response) !== 1){
            array_merge($response, $agenceResponse);
        }
        return reset($response[0]);
    }

    public function getPublicationOttRespons($criteria)
    {

        $response = $this->transcoAgenceRepo->findPublicationOtRequest($criteria);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }
}

