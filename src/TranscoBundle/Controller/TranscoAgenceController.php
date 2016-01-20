<?php

namespace TranscoBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Service\TranscoAgenceService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TranscoAgence controller
 * @RouteResource("TranscoAgence")
 */
class TranscoAgenceController extends FOSRestController
{
    /**
     * @var TranscoAgenceService
     * @DI\Inject("portal.service.transcoAgence")
     */
    protected $transcoAgenceService;

    /**
     * Lists all TranscoAgence entities.
     * @Rest\Get("/transcoagence/all")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoAgence",
     *      resource = true,
     *      description = "Lister la table TranscoAgence"
     * )
     */
    public function getAllAction()
    {
        return $this->transcoAgenceService->getAll();
    }

    /**
     * Creates a new TranscoAgence entity.
     * @Rest\Post("/transcoagence/create")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoAgence",
     *      resource = true,
     *      description = "Ajouter une ligne à la table TranscoAgence"
     * )
     * @param Request $request
     * @return TranscoAgence
     */
    public function createAction(Request $request)
    {
        return $this->transcoAgenceService->create($request);
    }

    /**
     * Finds and displays a TranscoAgence entity.
     * @Rest\Get("/transcoagence/{transcoAgenceId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoAgence",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoAgence",
     *      parameters={
     *          {"name"="transcoOpticId", "dataType"="Integer", "required"=true, "description"="Id TranscoAgence"},
     *      }
     * )
     * @param $transcoAgenceId
     * @return TranscoAgence
     */
    public function getAction($transcoAgenceId)
    {
        return $this->transcoAgenceService->get($transcoAgenceId);
    }

    /**
     * Displays a form to edit an existing TranscoAgence entity.
     * @Rest\Post("/transcoagence/{transcoAgenceId}/update")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoAgence",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoAgence",
     *      parameters={
     *          {"name"="transcoAgenceId", "dataType"="Integer", "required"=true, "description"="Id TranscoAgence"},
     *      }
     * )
     * @param Request $request
     * @param $transcoAgenceId
     * @return TranscoAgence
     */
    public function editAction(Request $request, $transcoAgenceId)
    {
        return $this->transcoAgenceService->edit($request, $transcoAgenceId);
    }

    /**
     * Deletes a TranscoAgence entity.
     * @Rest\Get("/transcoagence/{transcoAgenceId}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoAgence",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoAgence",
     *      parameters={
     *          {"name"="transcoAgenceId", "dataType"="Integer", "required"=true, "description"="Id TranscoAgence"},
     *      }
     * )
     * @param $transcoAgenceId
     */
    public function deleteAction($transcoAgenceId)
    {
        $this->transcoAgenceService->delete($transcoAgenceId);
    }
}
