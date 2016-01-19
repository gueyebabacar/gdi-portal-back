<?php

namespace TranscoBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Service\TranscoOpticService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TranscoOptic controller
 * @RouteResource("TranscoOptic")
 */
class TranscoOpticController extends FOSRestController
{

    /**
     * @var TranscoOpticService
     * @DI\Inject("portal.service.transcoOptic")
     */
    protected $transcoOpticService;

    /**
     * Lists all TranscoOptic entities.
     * @Rest\Get("/transcoptic/all")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoOptic",
     *      resource = true,
     *      description = "Lister la table TranscoOptic"
     * )
     */
    public function getAllAction()
    {
        return $this->transcoOpticService->getAll();
    }

    /**
     * Creates a new TranscoOptic entity.
     * @Rest\Post("/transcoptic/create")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoOptic",
     *      resource = true,
     *      description = "Ajouter une ligne à la table TranscoOptic"
     * )
     * @param Request $request
     * @return TranscoOptic
     */
    public function createAction(Request $request)
    {
        return $this->transcoOpticService->create($request);
    }

    /**
     * Finds and displays a TranscoOptic entity.
     * @Rest\Get("/transcoptic/{transcoOpticId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoOptic",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoOptic",
     *      parameters={
     *          {"name"="transcoOpticId", "dataType"="Integer", "required"=true, "description"="Id TranscoOptic"},
     *      }
     * )
     * @param $transcoOpticId
     * @return TranscoOptic
     */
    public function getAction($transcoOpticId)
    {
        return $this->transcoOpticService->get($transcoOpticId);
    }

    /**
     * Displays a form to edit an existing TranscoOptic entity.
     * @Rest\Post("/transconatureinter/{transcoOpticId}/update")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoOptic",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoOptic",
     *      parameters={
     *          {"name"="transcoOpticId", "dataType"="Integer", "required"=true, "description"="Id TranscoOptic"},
     *      }
     * )
     * @param Request $request
     * @param $transcoOpticId
     * @return TranscoOptic
     */
    public function editAction(Request $request, $transcoOpticId)
    {
        return $this->transcoOpticService->edit($request, $transcoOpticId);
    }

    /**
     * Deletes a TranscoOptic entity.
     * @Rest\Get("/transcoptic/{transcoOpticId}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoOptic",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoOptic",
     *      parameters={
     *          {"name"="transcoOpticId", "dataType"="Integer", "required"=true, "description"="Id TranscoOptic"},
     *      }
     * )
     * @param $transcoOpticId
     */
    public function deleteAction($transcoOpticId)
    {
        $this->transcoOpticService->delete($transcoOpticId);
    }
}
