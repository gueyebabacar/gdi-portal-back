<?php

namespace PortalBundle\Service\SoapService;

use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Service\TranscoDestTerrSiteService;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class TranscoDestTerrSiteService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.exposed_ws", public=true)
 */
class ExposedWSService
{
    //NatureInter
    const TERRITORY = "territory";
    const ID_REF_OP = "IdRefOp";
    const SITE = "site";
    const ADRESSEE = "adressee";
    const PR = "pr";


    /**
     * @var TranscoDestTerrSiteService
     * @DI\Inject("portal.service.trans.dest.terr.site")
     */
    public $transcoDestTerrSiteService;


    /**
     * @DI\InjectParams({
     *     "transcoDestTerrSiteService" = @DI\Inject("portal.service.trans.dest.terr.site"),
     * })
     * @param $transcoDestTerrSiteService
     */
    public function __construct($transcoDestTerrSiteService)
    {
        $this->transcoDestTerrSiteService = $transcoDestTerrSiteService;
    }

    /**
     * diffuserCalendrierRessource
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function transcoGdiService(\stdClass $data)
    {
        $response = new \stdClass();
        $response->codeReponse = new \stdClass();
        $response->reponseTranscoGDIServiceOutput = new \stdClass();

        $valeurRecherchee = $data->requeteTranscoGDIServiceInput->valeurRecherchee;
        $query['values']['query'] = $valeurRecherchee;

        foreach ($data->requeteTranscoGDIServiceInput->critere as $key => $item) {
            $query['criteria'][$key]['name'] = $item->NomCritere;
            $query['criteria'][$key]['value'] = $item->ValeurCritere;
        }

        try {
            switch ($valeurRecherchee) {

                case $this::TERRITORY:
                    $this->return['result'] = $this->$transcoDestTerrSiteService->getTerritory($query);
                    break;

                case $this::ID_REF_OP:
                $this->return['result'] = $this->transcoNatureInterService->getIdRefOperationnel($query);
                break;

                case $this::SITE:
                    $this->return['result'] = $this->transcoNatureInterService->getSite($query);
                    break;

                case $this::ADRESSEE:
                    $this->return['result'] = $this->transcoNatureInterService->getAdressee($query);
                    break;

                case $this::PR:
                    $this->return['result'] = $this->transcoNatureInterService->getPr($query);
                    break;

                default:
                    $this->return['result'] = null;
                    break;
            }
            $this->validationQuery($query);
            $response->reponseTranscoGDIServiceOutput->valeurTrouvee = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }


    private function validationQuery(array $query)
    {
        $fields = $this->fieldIsNull($query);
        if (!empty($fields)) {
            $this->return['result'] = '';
            $this->return['message'] = "Les champs obligatoires ne sont pas remplis:" . implode($fields);
            $this->return['code'] = "0000000001";
        } elseif ($this->return['result'] == null) {
            $this->return['result'] = '';
            $this->return['message'] = "ValeurRecherchee non reconnue";
            $this->return['code'] = "0000000003";
        } elseif(is_array($this->return['result'])) {
            $this->return['result'] = '';
            $this->return['message'] = "Transcodification impossible !";
            $this->return['code'] = "0000000002";
        } else {
            $this->return['message'] = "Succes";
            $this->return['code'] = "0000000000";
        }
    }

    private function fieldIsNull($query)
    {
        $fields = [];
        foreach ($query['criteria'] as $criteria) {
            if ($criteria['value'] == null) {
                $fields[] = $criteria['name'];
            }
        }
        if ($query['values']['query'] == null) {
            $fields[] = 'ValeurRecherchee';
        }
        return $fields;
    }
}
