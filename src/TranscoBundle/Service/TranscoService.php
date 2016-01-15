<?php

namespace TranscoBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Repository\TranscoAgenceRepository;
use TranscoBundle\Repository\TranscoDiscoRepository;

/**
 * Class TranscoService
 * @package TranscoBundle\Service
 *
 * @DI\Service("service.transco.transco-service", public=true)
 */
class TranscoService
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("service.transco.disco.repo")
     * @var TranscoDiscoRepository
     */
    public $transcoDiscoRepo;
//
//    /**
//     * @DI\Inject("service.transco.gmao.repo")
//     * @var TranscoGmaoRepository
//     */
//    public $transcoGmaoRepo;
//
//    /**
//     * @DI\Inject("service.transco.optic.repo")
//     * @var TranscoOpticRepository
//     */
//    public $transcoOpticRepo;

    /**
     * @DI\Inject("service.transcoq.agence.repo")
     * @var TranscoAgenceRepository
     */
    public $transcoAgenceRepo;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     *
     * @param $transcoDiscoRepo
     * @param $transcoGmaoRepo
     * @param $transcoOpticRepo
     * @param $transcoAgenceRepo
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "transcoDiscoRepo" = @DI\Inject("service.transco.disco.repo"),
     *     "transcoAgenceRepo" = @DI\Inject("service.transco.agence.repo"),
     * })
     */
    public function __construct($em, $transcoDiscoRepo, $transcoGmaoRepo, $transcoOpticRepo, $transcoAgenceRepo)
    {
        $this->em = $em;
        $this->transcoDiscoRepo = $transcoDiscoRepo;
        $this->transcoGmaoRepo = $transcoGmaoRepo;
        $this->transcoOpticRepo = $transcoOpticRepo;
        $this->transcoAgenceRepo = $transcoAgenceRepo;
    }

    public function getDelegationBiResponse()
    {
        
    }

    public function getDelegationOttResponse()
    {
        
    }

    public function getEnvoiDirgtResponse()
    {
        
    }

    public function getPublicationOttRespons()
    {

    }
}

