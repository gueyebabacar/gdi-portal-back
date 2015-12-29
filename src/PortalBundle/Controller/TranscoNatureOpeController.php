<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use PortalBundle\Service\TranscoNatureOpeService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Entity\TranscoNatureOpe;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TranscoNatureOpe controller
 */
class TranscoNatureOpeController extends FOSRestController
{

    /**
     * @var TranscoNatureOpeService
     * @DI\Inject("portal.service.TranscoNatureOpe")
     */
    protected $transcoNatureOpeService;

    /**
     * Lists all TranscoNatureOpe entities.
     * @Rest\Get("/transconatureope/all")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Lister la table TranscoNatureOpe"
     * )
     */
    public function indexAction()
    {
        return $this->transcoNatureOpeService->getAll();
    }

    /**
     * Creates a new TranscoNatureOpe entity.
     * @Rest\Post("/transconatureope/new")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Ajouter une ligne à la table TranscoNatureOpe"
     * )
     * @param Request $request
     * @return TranscoNatureOpe
     */
    public function newAction(Request $request)
    {
        return $this->transcoNatureOpeService->create($request);
    }

    /**
     * Finds and displays a TranscoNatureOpe entity.
     * @Rest\Get("/transconatureope/{transcoNatureOpeId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoNatureOpe",
     *      parameters={
     *          {"name"="transcoNatureOpeId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureOpe"},
     *      }
     * )
     * @param $transcoNatureOpeId
     * @return TranscoNatureOpe
     */
    public function getAction($transcoNatureOpeId)
    {
        return $this->transcoNatureOpeService->get($transcoNatureOpeId);
    }

    /**
     * Displays a form to edit an existing TranscoNatureOpe entity.
     * @Rest\Post("/transconatureope/{transcoNatureOpeId}/edit")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoNatureOpe",
     *      parameters={
     *          {"name"="transcoNatureOpeId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureOpe"},
     *      }
     * )
     * @param Request $request
     * @param $transcoNatureOpeId
     * @return TranscoNatureOpe
     */
    public function editAction(Request $request, $transcoNatureOpeId)
    {
        return $this->transcoNatureOpeService->edit($request, $transcoNatureOpeId);
    }

    /**
     * Deletes a TranscoNatureOpe entity.
     * @Rest\Get("/transconatureope/{transcoNatureOpeId}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoNatureOpe",
     *      parameters={
     *          {"name"="transcoNatureOpeId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureOpe"},
     *      }
     * )
     * @param $transcoNatureOpeId
     */
    public function deleteAction($transcoNatureOpeId)
    {
        $this->transcoNatureOpeService->delete($transcoNatureOpeId);
    }
}
