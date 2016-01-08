<?php

namespace TranscoBundle\Service;


use Doctrine\ORM\EntityManager;
use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Form\TranscoDestTerrSiteType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoDestTerrSiteService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.trans.dest.terr.site", public=true)
 */
class TranscoDestTerrSiteService
{
    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    /**
     * @DI\Inject("form.factory")
     * @var \Symfony\Component\Form\FormFactory
     */
    public $formFactory;

    /**
     * ControlService constructor.
     * @param EntityManager $em
     * @param FormFactory $formFactory
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "formFactory" = @DI\Inject("form.factory")
     * })
     */
    public function __construct($em, $formFactory)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    /**
     * Lists all TranscoNatureInter entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findAll();
    }

    /**
     * Creates a new TranscoDestTerrSite entity.
     * @param Request $request
     * @return TranscoDestTerrSite
     */
    public function create(Request $request)
    {
        $transcoDestTerrSite = new TranscoDestTerrSite();
        $form = $this->formFactory->create(TranscoDestTerrSiteType::class, $transcoDestTerrSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoDestTerrSite);
            $this->em->flush();
        }
        return $transcoDestTerrSite;
    }

    /**
     * Finds and displays a TranscoDestTerrSite entity.
     * @param $idRefStructureOp
     * @return null|object|TranscoDestTerrSite
     */
    public function get($idRefStructureOp)
    {
        return $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->find($idRefStructureOp);
    }

    /**
     * Displays a form to edit an existing TranscoDestTerrSite entity.
     * @param Request $request
     * @param $idRefStructureOp
     * @return TranscoDestTerrSite
     */
    public function edit(Request $request, $idRefStructureOp)
    {
        /** @var  $transcoDestTerrSite */
        $transcoDestTerrSite = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->find($idRefStructureOp);
        $form = $this->formFactory->create(TranscoDestTerrSiteType::class, $transcoDestTerrSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoDestTerrSite);
            $this->em->flush();
        }
        return $transcoDestTerrSite;
    }

    /**
     * Deletes a TranscoDestTerrSite entity.
     * @param $idRefStructureOp
     */
    public function delete($idRefStructureOp)
    {
        /** @var  $transcoDestTerrSite */
        $transcoDestTerrSite = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->find($idRefStructureOp);
        $this->em->remove($transcoDestTerrSite);
        $this->em->flush();
    }

    public function getTerritoryFromAtg(array $data)
    {
        $response =  $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findTerritoryFromAtg($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    public function getAtgFromTerritoryOrAdressee(array $data)
    {
        $response =  $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findAtgFromTerritoryOrAdressee($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    public function getAdresseeFromAtg(array $data){
        $response =  $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')-> findAdresseeFromAtg($data);
        if (sizeof($response) !== 1) {
            return $response;
        }
        return reset($response[0]);
    }

    public function getPrFromAtg(array $data){
        $response =  $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findPrFromAtg($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }
}

