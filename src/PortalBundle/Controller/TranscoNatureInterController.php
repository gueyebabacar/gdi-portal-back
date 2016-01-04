<?php

namespace PortalBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use PortalBundle\Service\TranscoNatureInterService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Entity\TranscoNatureInter;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TranscoNatureInter controller
 * @RouteResource("TranscoNatureInter")
 */
class TranscoNatureInterController extends FOSRestController
{

    /**
     * @var TranscoNatureInterService
     * @DI\Inject("portal.service.transconatureinter")
     */
    protected $transcoNatureInterService;

    /**
     * Lists all TranscoNatureInter entities.
     * @Rest\Get("/transconatureinter/all")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureInter",
     *      resource = true,
     *      description = "Lister la table TranscoNatureInter"
     * )
     */
    public function getAllAction()
    {
        return $this->transcoNatureInterService->getAll();
    }

    /**
     * Creates a new TranscoNatureInter entity.
     * @Rest\Post("/transconatureinter/create")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureInter",
     *      resource = true,
     *      description = "Ajouter une ligne à la table TranscoNatureInter"
     * )
     * @param Request $request
     * @return TranscoNatureInter
     */
    public function createAction(Request $request)
    {
        return $this->transcoNatureInterService->create($request);
    }

    /**
     * Finds and displays a TranscoNatureInter entity.
     * @Rest\Get("/transconatureinter/{transcoNatureInterId}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureInter",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoNatureInter",
     *      parameters={
     *          {"name"="transcoNatureInterId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureInter"},
     *      }
     * )
     * @param $transcoNatureInterId
     * @return TranscoNatureInter
     */
    public function getAction($transcoNatureInterId)
    {
        return $this->transcoNatureInterService->get($transcoNatureInterId);
    }

    /**
     * Displays a form to edit an existing TranscoNatureInter entity.
     * @Rest\Post("/transconatureinter/{transcoNatureInterId}/update")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureInter",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoNatureInter",
     *      parameters={
     *          {"name"="transcoNatureInterId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureInter"},
     *      }
     * )
     * @param Request $request
     * @param $transcoNatureInterId
     * @return TranscoNatureInter
     */
    public function editAction(Request $request, $transcoNatureInterId)
    {
        return $this->transcoNatureInterService->edit($request, $transcoNatureInterId);
    }

    /**
     * Deletes a TranscoNatureInter entity.
     * @Rest\Get("/transconatureinter/{transcoNatureInterId}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoNatureInter",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoNatureInter",
     *      parameters={
     *          {"name"="transcoNatureInterId", "dataType"="Integer", "required"=true, "description"="Id TranscoNatureInter"},
     *      }
     * )
     * @param $transcoNatureInterId
     */
    public function deleteAction($transcoNatureInterId)
    {
        $this->transcoNatureInterService->delete($transcoNatureInterId);
    }
}
