<?php

namespace TranscoBundle\Service;

use Doctrine\ORM\EntityManager;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Form\TranscoGmaoType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoGmaoService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.transcoGmao", public=true)
 */
class TranscoGmaoService
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
     * Lists all TranscoGmao entities.
     */
    public function getAll()
    {
        return $this->em->getRepository('TranscoBundle:TranscoGmao')->findAll();
    }

    /**
     * Creates a new TranscoGmao  entity.
     * @param Request $request
     * @return TranscoGmao
     */
    public function create(Request $request)
    {
        $transcoGmao = new TranscoGmao();
        $form = $this->formFactory->create(TranscoGmaoType::class, $transcoGmao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoGmao);
            $this->em->flush();
        }
        return $transcoGmao;
    }

    /**
     * Finds and displays a  entity.
     * @param $transcoGmaoId
     * @return null|object|TranscoGmao
     */
    public function get($transcoGmaoId)
    {
        return $this->em->getRepository('TranscoBundle:TranscoGmao')->find($transcoGmaoId);
    }

    /**
     * Displays a form to edit an existing TranscoGmao entity.
     * @param Request $request
     * @param $transcoGmaoId
     * @return \SvnLastRevisionTask
     */
    public function edit(Request $request, $transcoGmaoId)
    {
        /** @var TranscoGmao $transcoGmao */
        $transcoGmao = $this->em->getRepository('TranscoBundle:TranscoGmao')->find($transcoGmaoId);
        $form = $this->formFactory->create(TranscoGmaoType::class, $transcoGmao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoGmao);
            $this->em->flush();
        }
        return $transcoGmao;
    }

    /**
     * Deletes a TranscoGmao entity.
     * @param $transcoGmaoId
     */
    public function delete($transcoGmaoId)
    {
        /** @var TranscoGmao $transcoGmao */
        $transcoGmao = $this->em->getRepository('TranscoBundle:TranscoGmao')->find($transcoGmaoId);
        $this->em->remove($transcoGmao);
        $this->em->flush();
    }
}