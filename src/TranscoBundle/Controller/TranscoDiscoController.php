<?php

namespace TranscoBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Service\TranscoDiscoService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TranscoDisco controller
 * @RouteResource("TranscoDisco")
 */
class TranscoDiscoController extends FOSRestController
{

    /**
     * @var TranscoDiscoService
     * @DI\Inject("portal.service.transcoDisco")
     */
    protected $transcoDiscoService;

    /**
     * Lists all TranscoDisco entities.
     * @Rest\Get("/transcodisco/all")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDisco",
     *      resource = true,
     *      description = "Lister la table TranscoDisco"
     * )
     */
    public function getAllAction()
    {
        return $this->transcoDiscoService->getAll();
    }

    /**
     * Creates a new TranscoDisco entity.
     * @Rest\Post("/transcodisco/create")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDisco",
     *      resource = true,
     *      description = "Ajouter une ligne à la table TranscoDisco"
     * )
     * @param Request $request
     * @return TranscoDisco
     */
    public function createAction(Request $request)
    {
        return $this->transcoDiscoService->create($request);
    }

    /**
     * Finds and displays a TranscoDisco entity.
     * @Rest\Get("/transcodisco/{transcoDiscoId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDisco",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoDisco",
     *      parameters={
     *          {"name"="transcoDiscoId", "dataType"="Integer", "required"=true, "description"="Id TranscoDisco"},
     *      }
     * )
     * @param $transcoDiscoId
     * @return TranscoDisco
     */
    public function getAction($transcoDiscoId)
    {
        return $this->transcoDiscoService->get($transcoDiscoId);
    }

    /**
     * Displays a form to edit an existing TranscoDisco entity.
     * @Rest\Post("/transcodisco/{transcoDiscoId}/update")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDisco",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoDisco",
     *      parameters={
     *          {"name"="transcoDiscoId", "dataType"="Integer", "required"=true, "description"="Id TranscoDisco"},
     *      }
     * )
     * @param Request $request
     * @param $transcoDiscoId
     * @return TranscoDisco
     */
    public function editAction(Request $request, $transcoDiscoId)
    {
        return $this->transcoDiscoService->edit($request, $transcoDiscoId);
    }

    /**
     * Deletes a TranscoDisco entity.
     * @Rest\Get("/transcodisco/{transcoDiscoId}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDisco",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoDisco",
     *      parameters={
     *          {"name"="transcoDiscoId", "dataType"="Integer", "required"=true, "description"="Id TranscoDisco"},
     *      }
     * )
     * @param $transcoDiscoId
     */
    public function deleteAction($transcoDiscoId)
    {
        $this->transcoDiscoService->delete($transcoDiscoId);
    }
}
