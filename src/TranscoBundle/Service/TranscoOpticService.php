<?php

namespace TranscoBundle\Service;


use Doctrine\ORM\EntityManager;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Form\TranscoOpticType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoOpticService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.transcoOptic", public=true)
 */
class TranscoOpticService
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
     * Lists all TranscoDisco entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('TranscoOptic')->findAll();
    }

    /**
     * Creates a new TranscoOptic  entity.
     * @param Request $request
     * @return TranscoOptic
     */
    public function create(Request $request)
    {
        $transcoOptic = new TranscoOptic();
        $form = $this->formFactory->create(TranscoOpticType::class, $transcoOptic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoOptic);
            $this->em->flush();
        }
        return $transcoOptic;
    }

    /**
     * Finds and displays a  entity.
     * @param $transcoOpticId
     * @return null|object|TranscoOptic
     */
    public function get($transcoOpticId)
    {
        return $this->em->getRepository('TrancoOptic')->find($transcoOpticId);
    }

    /**
     * Displays a form to edit an existing TranscoOptic entity.
     * @param Request $request
     * @param $transcoOpticId
     * @return \SvnLastRevisionTask
     */
    public function edit(Request $request, $transcoOpticId)
    {
        /** @var TranscoOptic $transcoOptic */
        $transcoOptic = $this->em->getRepository('TranscoOptic')->find($transcoOpticId);
        $form = $this->formFactory->create(TranscoOpticType::class, $transcoOptic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoOptic);
            $this->em->flush();
        }
        return $transcoOptic;
    }

    /**
     * Deletes a TranscoOptic entity.
     * @param $transcoOpticId
     */
    public function delete($transcoOpticId)
    {
        /** @var TranscoOptic $transcoOptic */
        $transcoOptic = $this->em->getRepository('TranscoOptic')->find($transcoOpticId);
        $this->em->remove($transcoOptic);
        $this->em->flush();
    }

    /**
     * Return CodeNatureIntervention, CodeFinalite, CodeSegementation, ModeProgrammation
     * from  TypeDeTravail, GroupDeGamme, Compteur
     * @param array $data
     * @return mixed
     */
    public function getDelegationOt(array $data){
        $response = $this->em->getRepository('TranscoBundle:TranscoOptic')->findDelegationOT($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    /**
     * Return NatOpCode from NatIntCode
     * @param array $data
     * @return mixed
     */
    public function getDelegationBi(array $data){
        $response =  $this->em->getRepository('TranscoBundle:TranscoOptic')->findDelegationBI($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }
}