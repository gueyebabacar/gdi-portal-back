<?php

namespace TranscoBundle\Service;


use Doctrine\ORM\EntityManager;
use TranscoBundle\Entity\TranscoNatureOpe;
use TranscoBundle\Form\TranscoNatureOpeType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoNatureOpeService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.transconatureope", public=true)
 */
class TranscoNatureOpeService
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
     * Lists all TranscoNatureOpe entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('TranscoBundle:TranscoNatureOpe')->findAll();
    }

    /**
     * Creates a new TranscoNatureOpe entity.
     * @param Request $request
     * @return TranscoNatureOpe
     */
    public function create(Request $request)
    {
        $transcoNatureOpe = new TranscoNatureOpe();
        $form = $this->formFactory->create(TranscoNatureOpeType::class, $transcoNatureOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoNatureOpe);
            $this->em->flush();
        }
        return $transcoNatureOpe;
    }

    /**
     * Finds and displays a TranscoNatureOpe entity.
     * @param $transcoNatureOpeId
     * @return null|object|TranscoNatureOpe
     */
    public function get($transcoNatureOpeId)
    {
        return $this->em->getRepository('TranscoBundle:TranscoNatureOpe')->find($transcoNatureOpeId);
    }

    /**
     * Displays a form to edit an existing TranscoNatureOpe entity.
     * @param Request $request
     * @param $transcoNatureOpeId
     * @return TranscoNatureOpe
     */
    public function edit(Request $request, $transcoNatureOpeId)
    {
        /** @var TranscoNatureOpe $transcoNatureOpe */
        $transcoNatureOpe = $this->em->getRepository('TranscoBundle:TranscoNatureOpe')->find($transcoNatureOpeId);
        $form = $this->formFactory->create(TranscoNatureOpeType::class, $transcoNatureOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoNatureOpe);
            $this->em->flush();
        }
        return $transcoNatureOpe;
    }

    /**
     * Deletes a TranscoNatureOpe entity.
     * @param $transcoNatureOpeId
     */
    public function delete($transcoNatureOpeId)
    {
        /** @var TranscoNatureOpe $transcoNatureOpe */
        $transcoNatureOpe = $this->em->getRepository('TranscoBundle:TranscoNatureOpe')->find($transcoNatureOpeId);
        $this->em->remove($transcoNatureOpe);
        $this->em->flush();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getCodeNatureIntervention3(array $data){
        $response = $this->em->getRepository('TranscoBundle:TranscoNatureOpe')->getCodeNatureIntervention3($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getModeProgrammation(array $data){
        $response =  $this->em->getRepository('TranscoBundle:TranscoNatureOpe')->getModeProgrammation($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }
}