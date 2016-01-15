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
     *  @DI\Inject("service.transco.transco-service")
     */
    public $transcoService;

    /**
     * @var $return
     */
    private $return;

    /**
     * @DI\InjectParams({
     *     "transcoService" = @DI\Inject("service.transco.transco-service"),
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
    public function delegationOTTranscoServiceAction(\stdClass $data)
    {
        dump($data);exit;
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
//            $this->return['result'] = appel fonction service;

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

    /**
     * delegationBITranscoService
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function delegationBITranscoServiceAction(\stdClass $data)
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
//            $this->return['result'] = appel fonction service;

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
        $query['values']['query'] = $valeurRecherchee;

        foreach ($data->requeteTranscoGDIServiceInput->critere as $key => $item) {
            $query['criteria'][$key]['name'] = $item->NomCritere;
            $query['criteria'][$key]['value'] = $item->ValeurCritere;
        }

        try {
//            $this->return['result'] = appel fonction service;

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
        $query['values']['query'] = $valeurRecherchee;

        foreach ($data->requeteTranscoGDIServiceInput->critere as $key => $item) {
            $query['criteria'][$key]['name'] = $item->NomCritere;
            $query['criteria'][$key]['value'] = $item->ValeurCritere;
        }

        try {
//            $this->return['result'] = appel fonction service;

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

    /**
     * @param array $query
     */
    private function validationQuery(array $query)
    {
        $fields = $this->fieldIsNull($query);
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
     * @param $query
     * @return array
     */
    private function fieldIsNull($query)
    {
        $fields = [];
        foreach ($query['criteria'] as $criteria) {
            if ($criteria['value'] == null || $criteria['name'] == null) {
                $fields[] = $criteria['name'];
            }
        }
        if ($query['values']['query'] == null) {
            $fields[] = 'ValeurRecherchee';
        }
        return $fields;
    }
}
