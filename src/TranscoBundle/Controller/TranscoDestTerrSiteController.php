<?php

namespace TranscoBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use TranscoBundle\Service\TranscoDestTerrSiteService;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoDestTerrSite;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * TranscoNatureInter controller
 * @RouteResource("TranscoDestTerrSite")
 */
class TranscoDestTerrSiteController extends FOSRestController
{

    /**
     * @var TranscoDestTerrSiteService
     * @DI\Inject("portal.service.trans.dest.terr.site")
     */
    protected $transcoDestTerrSiteService;

    /**
     * Lists all TranscoDestTerrSite entities.
     * @Rest\Get("/transcodestersite/all")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDestTerrSite",
     *      resource = true,
     *      description = "Lister la table TranscoDestTerrSite"
     * )
     */
    public function getAllAction()
    {
        return $this->transcoDestTerrSiteService->getAll();
    }

    /**
     * Creates a new TranscoDestTerrSite entity.
     * @Rest\Post("/transcodestersite/create")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDestTerrSite",
     *      resource = true,
     *      description = "Ajouter une ligne à la table TranscoDestTerrSite"
     * )
     * @param Request $request
     * @return TranscoDestTerrSite
     */
    public function createAction(Request $request)
    {
        return $this->transcoDestTerrSiteService->create($request);
    }

    /**
     * Finds and displays a TranscoDestTerrSite entity.
     * @Rest\Get("/transcodestersite/{idRefStructureOp}")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDestTerrSite",
     *      resource = true,
     *      description = "Afficher une ligne de la table TranscoDestTerrSite",
     *      parameters={
     *          {"name"="idRefStructureOp", "dataType"="Integer", "required"=true, "description"="Id TranscoDestTerrSite"},
     *      }
     * )
     * @param $idRefStructureOp
     * @return TranscoDestTerrSite
     */
    public function getAction($idRefStructureOp)
    {
        return $this->transcoDestTerrSiteService->get($idRefStructureOp);
    }

    /**
     * Displays a form to edit an existing TranscoDestTerrSite entity.
     * @Rest\Post("/transcodestersite/{idRefStructureOp}/update")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDestTerrSite",
     *      resource = true,
     *      description = "Editer une ligne de la table TranscoDestTerrSite",
     *      parameters={
     *          {"name"="idRefStructureOp", "dataType"="Integer", "required"=true, "description"="Id TranscoDestTerrSite"},
     *      }
     * )
     * @param Request $request
     * @param $idRefStructureOp
     * @return TranscoDestTerrSite
     */
    public function updateAction(Request $request, $idRefStructureOp)
    {
        return $this->transcoDestTerrSiteService->edit($request, $idRefStructureOp);
    }

    /**
     * Deletes a TranscoDestTerrSite entity.
     * @Rest\Get("/transcodestersite/{idRefStructureOp}/delete")
     * @Rest\View
     *
     * @ApiDoc(
     *      section = "TranscoDestTerrSite",
     *      resource = true,
     *      description = "Supprime une ligne de la table TranscoDestTerrSite",
     *      parameters={
     *          {"name"="idRefStructureOp", "dataType"="Integer", "required"=true, "description"="Id TranscoDestTerrSite"},
     *      }
     * )
     * @param $idRefStructureOp
     */
    public function deleteAction($idRefStructureOp)
    {
        $this->transcoDestTerrSiteService->delete($idRefStructureOp);
    }
}
