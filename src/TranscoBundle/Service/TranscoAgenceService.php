<?php

namespace TranscoBundle\Service;


use Doctrine\ORM\EntityManager;
use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Form\TranscoAgenceType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoAgenceService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.transcoAgence", public=true)
 */
class TranscoAgenceService
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
     * Lists all TranscoAgence entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('TranscoAgence')->findAll();
    }

    /**
     * Creates a new TranscoAgence  entity.
     * @param Request $request
     * @return TranscoAgence
     */
    public function create(Request $request)
    {
        $transcoAgence = new TranscoAgence();
        $form = $this->formFactory->create(TranscoAgenceType::class, $transcoAgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoAgence);
            $this->em->flush();
        }
        return $transcoAgence;
    }

    /**
     * Finds and displays a  entity.
     * @param $transcoAgenceId
     * @return null|object|TranscoAgence
     */
    public function get($transcoAgenceId)
    {
        return $this->em->getRepository('TrancoAgence')->find($transcoAgenceId);
    }

    /**
 * Displays a form to edit an existing TranscoAgence entity.
     * @param Request $request
     * @param $transcoAgenceId
     * @return \SvnLastRevisionTask
     */
    public function edit(Request $request, $transcoAgenceId)
    {
        /** @var TranscoAgence $transcoAgence */
        $transcoAgence = $this->em->getRepository('TranscoBundle:TranscoAgence')->find($transcoAgenceId);
        $form = $this->formFactory->create(TranscoAgenceType::class, $transcoAgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoAgence);
            $this->em->flush();
        }
        return $transcoAgence;
    }

    /**
     * Deletes a TranscoAgence entity.
     * @param $transcoAgenceId
     */
    public function delete($transcoAgenceId)
    {
        /** @var TranscoAgence $transcoAgence */
        $transcoAgence = $this->em->getRepository('TranscoBundle:TranscoAgence')->find($transcoAgenceId);
        $this->em->remove($transcoAgence);
        $this->em->flush();
    }

    /**
     * Return destinataire, center from codeAgence, inseeCode
     * @param array $data
     * @return mixed
     */
    public function getEnvoiDIRG(array $data){
        $response =  $this->em->getRepository('TranscoBundle:TranscoAgence')->findEnvoiDirgAgenceRequest($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    /**
     * Return pr from codeAgence
     * @param array $data
     * @return mixed
     */
    public function getPublicationOt(array $data){
        $response =  $this->em->getRepository('TranscoBundle:TranscoAgence')->findPublicationOtRequest($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }
}