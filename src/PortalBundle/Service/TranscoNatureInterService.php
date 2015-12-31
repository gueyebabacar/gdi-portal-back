<?php

namespace PortalBundle\Service;


use Doctrine\ORM\EntityManager;
use PortalBundle\Entity\TranscoNatureInter;
use PortalBundle\Form\TranscoNatureInterType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoNatureInterService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.transconatureinter", public=true)
 */
class TranscoNatureInterService
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
        return $transcoNatureInters = $this->em->getRepository('PortalBundle:TranscoNatureInter')->findAll();
    }

    /**
     * Creates a new TranscoNatureInter entity.
     * @param Request $request
     * @return TranscoNatureInter
     */
    public function create(Request $request)
    {
        $transcoNatureInter = new TranscoNatureInter();
        $form = $this->formFactory->create(new TranscoNatureInterType(), $transcoNatureInter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoNatureInter);
            $this->em->flush();
        }
        return $transcoNatureInter;
    }

    /**
     * Finds and displays a TranscoNatureInter entity.
     * @param $transcoNatureInterId
     * @return null|object|TranscoNatureInter
     */
    public function get($transcoNatureInterId)
    {
        return $this->em->getRepository('PortalBundle:TranscoNatureInter')->find($transcoNatureInterId);
    }

    /**
     * Displays a form to edit an existing TranscoNatureInter entity.
     * @param Request $request
     * @param $transcoNatureInterId
     * @return TranscoNatureInter
     */
    public function edit(Request $request, $transcoNatureInterId)
    {
        /** @var TranscoNatureInter $transcoNatureInter */
        $transcoNatureInter = $this->em->getRepository('PortalBundle:TranscoNatureInter')->find($transcoNatureInterId);
        $form = $this->formFactory->create(new TranscoNatureInterType(), $transcoNatureInter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoNatureInter);
            $this->em->flush();
        }
        return $transcoNatureInter;
    }

    /**
     * Deletes a TranscoNatureInter entity.
     * @param $transcoNatureInterId
     */
    public function delete($transcoNatureInterId)
    {
        /** @var TranscoNatureInter $transcoNatureInter */
        $transcoNatureInter = $this->em->getRepository('PortalBundle:TranscoNatureInter')->find($transcoNatureInterId);
        $this->em->remove($transcoNatureInter);
        $this->em->flush();
    }

    public function getCodeNatIntFromCodeNatOp(array $data){
        $response = $this->em->getRepository('PortalBundle:TranscoNatureInter')->findCodeNatIntFromCodeNatOp($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }

    public function getCodeNatOpFromCodeNatInt(array $data){
        $response =  $this->em->getRepository('PortalBundle:TranscoNatureInter')->findCodeNatopFromCodeNatInt($data);
        if(sizeof($response) !== 1){
            return $response;
        }
        return reset($response[0]);
    }
}