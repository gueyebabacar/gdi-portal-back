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
     * @Rest\Get("/TranscoNatureOpe/all")
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
     * @Rest\Post("/TranscoNatureOpe/new")
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
     * @Rest\Get("/TranscoNatureOpe/{TranscoNatureOpeId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoNatureOpe",
     *      parameters={
     *          {"name"="TranscoNatureOpeId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureOpe"},
     *      }
     * )
     * @param $TranscoNatureOpeId
     * @return TranscoNatureOpe
     */
    public function showAction($TranscoNatureOpeId)
    {
        return $this->transcoNatureOpeService->get($TranscoNatureOpeId);
    }

    /**
     * Displays a form to edit an existing TranscoNatureOpe entity.
     * @Rest\Post("/TranscoNatureOpe/{TranscoNatureOpeId}/edit")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoNatureOpe",
     *      parameters={
     *          {"name"="TranscoNatureOpeId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureOpe"},
     *      }
     * )
     * @param Request $request
     * @param $TranscoNatureOpeId
     * @return TranscoNatureOpe
     */
    public function editAction(Request $request, $TranscoNatureOpeId)
    {
        return $this->transcoNatureOpeService->edit($request, $TranscoNatureOpeId);
    }

    /**
     * Deletes a TranscoNatureOpe entity.
     * @Rest\Get("/TranscoNatureOpe/{TranscoNatureOpeId}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureOpe",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoNatureOpe",
     *      parameters={
     *          {"name"="TranscoNatureOpeId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureOpe"},
     *      }
     * )
     * @param $TranscoNatureOpeId
     */
    public function deleteAction($TranscoNatureOpeId)
    {
        $this->transcoNatureOpeService->delete($TranscoNatureOpeId);
    }
}
