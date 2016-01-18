<?php

namespace TranscoBundle\Service\SoapService;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\PropertyInfo\Type;
use TranscoBundle\Service\TranscoService;

/**
 * Class ExposedWSService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.exposed_ws", public=true)
 */
class ExposedWSService
{
    //delegationOTTranscoGDIService
    const WORK_TYPE = "TypeDeTravail";
    const GAMME_GROUP = "GroupeDeGamme";
    const COUNTER = "Compteur";

    //delegationBITranscoGDIService
    const CODE_NAT_OP = "CodeNatureOperation";
    const CODE_OBJECT = "CodeObjet";
    const SOURCE = "Source";

    //DestTerrSite
    const TERRITORY = "Territoire";
    const ADRESSEE = "Destinataire";
    const PR = "PR";
    const ATG = "ATG";

    /**
     * @var TranscoService
     *  @DI\Inject("service.transco.transcoservice")
     */
    public $transcoService;

    /**
     * @var $return
     */
    private $return;

    /**
     * @DI\InjectParams({
     *     "transcoService" = @DI\Inject("service.transco.transcoservice"),
     * })
     * @param $transcoService
     */
    public function __construct($transcoService)
    {
        $this->transcoService = $transcoService;
    }

    /**
     * delegationOTTranscoServiceAction
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function delegationOTTranscoService(\stdClass $data)
    {
        $response = new \stdClass();
        $response->codeReponse = new \stdClass();
        $response->delegationOTTranscoGDIServiceOutput = new \stdClass();
        $response->delegationOTTranscoGDIServiceOutput->Reponse = new \stdClass();

        $criteria = [];

        foreach ($data->delegationOTTranscoGDIServiceInput->Critere as $key => $item) {
            $criteria[$key]['name'] = $item->NomCritere;
            $criteria[$key]['value'] = $item->ValeurCritere;
        }

        try {
//            $this->return['result'] = appel fonction service;
            $this->return['result'] = $this->transcoService->getDelegationOttResponse($criteria);

            $this->validationQuery($criteria);
            $response->delegationOTTranscoGDIServiceOutput->Reponse  = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }

    /**
     * delegationBITranscoService
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function delegationBITranscoService(\stdClass $data)
    {
        $response = new \stdClass();
        $response->codeReponse = new \stdClass();
        $response->reponseTranscoGDIServiceOutput = new \stdClass();

        $valeurRecherchee = $data->requeteTranscoGDIServiceInput->valeurRecherchee;
        $criteria['values']['query'] = $valeurRecherchee;

        foreach ($data->requeteTranscoGDIServiceInput->critere as $key => $item) {
            $criteria['criteria'][$key]['name'] = $item->NomCritere;
            $criteria['criteria'][$key]['value'] = $item->ValeurCritere;
        }

        try {
//            $this->return['result'] = appel fonction service;

            $this->validationQuery($criteria);
            $response->reponseTranscoGDIServiceOutput->valeurTrouvee = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }

    /**
     * delegationBITranscoService
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function envoiDIRGTranscoGDIService(\stdClass $data)
    {
        $response = new \stdClass();
        $response->codeReponse = new \stdClass();
        $response->reponseTranscoGDIServiceOutput = new \stdClass();

        $valeurRecherchee = $data->requeteTranscoGDIServiceInput->valeurRecherchee;
        $criteria['values']['query'] = $valeurRecherchee;

        foreach ($data->requeteTranscoGDIServiceInput->critere as $key => $item) {
            $criteria['criteria'][$key]['name'] = $item->NomCritere;
            $criteria['criteria'][$key]['value'] = $item->ValeurCritere;
        }

        try {
//            $this->return['result'] = appel fonction service;

            $this->validationQuery($criteria);
            $response->reponseTranscoGDIServiceOutput->valeurTrouvee = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }

    /**
     * delegationBITranscoService
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function publicationOTTranscoGDIService(\stdClass $data)
    {
//        dump($data);exit;
        $response = new \stdClass();
        $response->codeReponse = new \stdClass();
        $response->reponseTranscoGDIServiceOutput = new \stdClass();

        $valeurRecherchee = $data->requeteTranscoGDIServiceInput->valeurRecherchee;
        $criteria['values']['query'] = $valeurRecherchee;

        foreach ($data->requeteTranscoGDIServiceInput->critere as $key => $item) {
            $criteria['criteria'][$key]['name'] = $item->NomCritere;
            $criteria['criteria'][$key]['value'] = $item->ValeurCritere;
        }

        try {
//            $this->return['result'] = appel fonction service;

            $this->validationQuery($criteria);
            $response->reponseTranscoGDIServiceOutput->valeurTrouvee = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }

    /**
     * @param array $criteria
     */
    private function validationQuery(array $criteria)
    {
        $fields = $this->fieldIsNull($criteria);
        if (!empty($fields)) {
            $this->return['result'] = '';
            $this->return['message'] = "Les champs obligatoires ne sont pas remplis:" . implode($fields, ', ');
            $this->return['code'] = "0000000001";
        } elseif ($this->return['result'] == null) {
            $this->return['result'] = '';
            $this->return['message'] = "ValeurRecherchee non reconnue";
            $this->return['code'] = "0000000003";
        } elseif (is_array($this->return['result'])) {
            $this->return['result'] = '';
            $this->return['message'] = "Transcodification impossible !";
            $this->return['code'] = "0000000002";
        } else {
            $this->return['message'] = "Succes";
            $this->return['code'] = "0000000000";
        }
    }

    /**
     * @param $criteria
     * @return array
     */
    private function fieldIsNull($criteria)
    {
        $fields = [];
        foreach ($criteria as $crit) {
            if ($crit['value'] == null || $crit['name'] == null) {
                $fields[] = $crit['name'];
            }
        }
        return $fields;
    }
}
