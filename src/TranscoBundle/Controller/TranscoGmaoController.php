<?php

namespace TranscoBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Service\TranscoOpticService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TranscoGmao controller
 * @RouteResource("TranscoGmao")
 */
class TranscoGmaoController extends FOSRestController
{

    /**
     * @var TranscoOpticService
     * @DI\Inject("portal.service.transcoGmao")
     */
    protected $transcoGmaoService;

    /**
     * Lists all TranscoDisco entities.
     * @Rest\Get("/transcogmao/all")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoGmao",
     *      resource = true,
     *      description = "Lister la table TranscoGmao"
     * )
     */
    public function getAllAction()
    {
        return $this->transcoGmaoService->getAll();
    }

    /**
     * Creates a new TranscoGmao entity.
     * @Rest\Post("/transcogmao/create")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoGmao",
     *      resource = true,
     *      description = "Ajouter une ligne à la table TranscoGmao"
     * )
     * @param Request $request
     * @return TranscoGmao
     */
    public function createAction(Request $request)
    {
        return $this->transcoGmaoService->create($request);
    }

    /**
     * Finds and displays a TranscoGmao entity.
     * @Rest\Get("/transcoGmao/{transcoGmaoId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoGmao",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoGmao",
     *      parameters={
     *          {"name"="transcoGmaoId", "dataType"="Integer", "required"=true, "description"="Id TranscoGmao"},
     *      }
     * )
     * @param $transcoGmaoId
     * @return TranscoGmao
     */
    public function getAction($transcoGmaoId)
    {
        return $this->transcoGmaoService->get($transcoGmaoId);
    }

    /**
     * Displays a form to edit an existing TranscoOptic entity.
     * @Rest\Post("/transcogmao/{transcoGmaoId}/update")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoGmao",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoGmao",
     *      parameters={
     *          {"name"="transcoGmaoId", "dataType"="Integer", "required"=true, "description"="Id TranscoGmao"},
     *      }
     * )
     * @param Request $request
     * @param $transcoGmaoId
     * @return TranscoGmao
     */
    public function editAction(Request $request, $transcoGmaoId)
    {
        return $this->transcoGmaoService->edit($request, $transcoGmaoId);
    }

    /**
     * Deletes a TranscoGmao entity.
     * @Rest\Get("/transcoGmao/{transcoGmaoId}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoGmao",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoGmao",
     *      parameters={
     *          {"name"="transcoGmaoId", "dataType"="Integer", "required"=true, "description"="Id TranscoGmao"},
     *      }
     * )
     * @param $transcoGmaoId
     */
    public function deleteAction($transcoGmaoId)
    {
        $this->transcoGmaoService->delete($transcoGmaoId);
    }
}
