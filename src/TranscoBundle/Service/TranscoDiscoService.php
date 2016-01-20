<?php

namespace TranscoBundle\Service;

use Doctrine\ORM\EntityManager;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Form\TranscoDiscoType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class TranscoDiscoService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.transcoDisco", public=true)
 */
class TranscoDiscoService
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
     * List TranscoDisco
     * @return array|\TranscoBundle\Entity\TranscoDisco[]
     */
    public function getAll()
    {
        return $this->em->getRepository('TranscoBundle:TranscoDisco')->findAll();
    }

    /**
     * Creates a new TranscoDisco entity.
     * @param Request $request
     * @return TranscoDisco
     */
    public function create(Request $request)
    {
        $transcoDisco = new TranscoDisco();
        $form = $this->formFactory->create(TranscoDiscoType::class, $transcoDisco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoDisco);
            $this->em->flush();
        }
        return $transcoDisco;
    }

    /**
     * Finds and displays a  entity.
     * @param $transcoDisco
     * @return null|object|TranscoDisco
     */
    public function get($transcoDisco)
    {
        return $this->em->getRepository('TranscoBundle:TranscoDisco')->find($transcoDisco);
    }

    /**
     * Displays a form to edit an existing TranscoDisco entity.
     * @param Request $request
     * @param $transcoDiscoId
     * @return null|object|TranscoOptic
     */
    public function edit(Request $request, $transcoDiscoId)
    {
        /** @var TranscoOptic $transcoOptic */
        $transcoDisco = $this->em->getRepository('TranscoBundle:TranscoDisco')->find($transcoDiscoId);
        $form = $this->formFactory->create(TranscoDiscoType::class, $transcoDisco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($transcoDisco);
            $this->em->flush();
        }
        return $transcoDisco;
    }

    /**
     * Deletes a TranscoOptic entity.
     * @param $transcoDiscoId
     */
    public function delete($transcoDiscoId)
    {
        /** @var TranscoOptic $transcoOptic */
        $transcoDisco = $this->em->getRepository('TranscoBundle:TranscoDisco')->find($transcoDiscoId);
        $this->em->remove($transcoDisco);
        $this->em->flush();
    }
}