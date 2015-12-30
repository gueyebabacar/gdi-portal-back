<?php

namespace PortalBundle\Service;


use Doctrine\ORM\EntityManager;
use PortalBundle\Entity\TranscoNatureOpe;
use PortalBundle\Form\TranscoNatureOpeType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoNatureOpeService
 * @package PortalBundle\Service
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
        return $TranscoNatureOpes = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->findAll();
    }

    /**
     * Creates a new TranscoNatureOpe entity.
     * @param Request $request
     * @return TranscoNatureOpe
     */
    public function create(Request $request)
    {
        $TranscoNatureOpe = new TranscoNatureOpe();
        $form = $this->formFactory->create(new TranscoNatureOpeType(), $TranscoNatureOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($TranscoNatureOpe);
            $this->em->flush();
        }
        return $TranscoNatureOpe;
    }

    /**
     * Finds and displays a TranscoNatureOpe entity.
     * @param $transcoNatureOpeId
     * @return null|object|TranscoNatureOpe
     */
    public function get($transcoNatureOpeId)
    {
        return $this->em->getRepository('PortalBundle:TranscoNatureOpe')->find($transcoNatureOpeId);
    }

    /**
     * Displays a form to edit an existing TranscoNatureOpe entity.
     * @param Request $request
     * @param $transcoNatureOpeId
     * @return TranscoNatureOpe
     */
    public function edit(Request $request, $transcoNatureOpeId)
    {
        /** @var TranscoNatureOpe $TranscoNatureOpe */
        $TranscoNatureOpe = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->find($transcoNatureOpeId);
        $form = $this->formFactory->create(new TranscoNatureOpeType(), $TranscoNatureOpe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($TranscoNatureOpe);
            $this->em->flush();
        }
        return $TranscoNatureOpe;
    }

    /**
     * Deletes a TranscoNatureOpe entity.
     * @param $transcoNatureOpeId
     */
    public function delete($transcoNatureOpeId)
    {
        /** @var TranscoNatureOpe $TranscoNatureOpe */
        $TranscoNatureOpe = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->find($transcoNatureOpeId);
        $this->em->remove($TranscoNatureOpe);
        $this->em->flush();
    }
}