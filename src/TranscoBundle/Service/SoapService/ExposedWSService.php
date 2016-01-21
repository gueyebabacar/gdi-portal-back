<?php

namespace TranscoBundle\Service\SoapService;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\PropertyInfo\Type;
use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Service\TranscoService;

/**
 * Class ExposedWSService
 * @package TranscoBundle\Service
 *
 * @DI\Service("portal.service.exposed_ws", public=true)
 */
class ExposedWSService
{
    //Request input names
    const DELEGATION_OT = "delegationOTTranscoGDIServiceInput";
    const DELEGATION_BI = "delegationBITranscoGDIServiceInput";
    const ENVOI_DIRG = "envoiDIRGTranscoGDIServiceInput";
    const PUBLICATION_OT = "publicationOTTranscoGDIServiceInput";

    //Error codes
    const ERROR_MISSING_FIELDS = '0000000001';
    const ERROR_IMPOSSIBLE_TRANSCODIFICATION = '0000000002';
    const ERROR_NOT_FOUND = '0000000003';
    const ERROR_SOURCE_INCORRECT = '0000000004';

    /**
     * @var TranscoService
     * @DI\Inject("service.transco.transcoservice")
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
        $criteria = [];
        $response = new \stdClass();
        $response->delegationOTTranscoGDIServiceOutput = new \stdClass();
        $response->delegationOTTranscoGDIServiceOutput->Reponse = [];
        $response->codeReponse = new \stdClass();

        $expectedFields = [
            TranscoGmao::TYPE_DE_TRAVAIL,
            TranscoGmao::GROUPE_DE_GAMME,
            TranscoGmao::COMPTEUR
        ];

        if (key($data) === $this::DELEGATION_OT) {
            $criteria = $this->extractCriteria($data);
        }

        try {
            $this->return['result'] = $this->transcoService->getDelegationOtResponse($criteria);
            $this->validationQuery($criteria, $expectedFields);
            $response->delegationOTTranscoGDIServiceOutput->Reponse = $this->return['result'];
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
        $criteria = [];
        $sourceCorrect = true;
        $response = new \stdClass();
        $response->delegationBITranscoGDIServiceOutput = new \stdClass();
        $response->delegationBITranscoGDIServiceOutput->Reponse = [];
        $response->codeReponse = new \stdClass();

        $expectedFields = [
            TranscoDisco::CODE_NAT_OP,
            TranscoDisco::CODE_OBJECT,
            TranscoDisco::SOURCE,
        ];

        if (key($data) === $this::DELEGATION_BI) {
            $criteria = $this->extractCriteria($data);
        }

        foreach ($criteria as $item) {
            if ($item['name'] == 'Source' && ($item['value'] != 'Disco' && $item['value'] != 'Pictrel')) {
                $sourceCorrect = false;
            }
        }

        try {
            $this->return['result'] = $this->transcoService->getDelegationBiResponse($criteria);
            $this->validationQuery($criteria, $expectedFields, $sourceCorrect);
            $response->delegationBITranscoGDIServiceOutput->Reponse = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }

    /**
     * envoiDIRGTranscoGDIService
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function envoiDIRGTranscoService(\stdClass $data)
    {
        $criteria = [];
        $response = new \stdClass();
        $response->envoiDIRGTranscoGDIServiceOutput = new \stdClass();
        $response->envoiDIRGTranscoGDIServiceOutput->Reponse = [];
        $response->codeReponse = new \stdClass();

        $expectedFields = [
            TranscoOptic::CODE_NAT_INT,
            TranscoOptic::CODE_FINALITE,
            TranscoOptic::CODE_SEGMENTATION,
            TranscoAgence::CODE_AGENCE,
            TranscoAgence::CODE_INSEE,
        ];

        if (key($data) === $this::ENVOI_DIRG) {
            $criteria = $this->extractCriteria($data);
        }

        try {
            $this->return['result'] = $this->transcoService->getEnvoiDirgtResponse($criteria);
            $this->validationQuery($criteria, $expectedFields);
            $response->envoiDIRGTranscoGDIServiceOutput->Reponse = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }

    /**
     * publicationOTTranscoGDIService
     *
     * @param \stdClass|Type $data
     * @return \stdClass
     */
    public function publicationOTTranscoService(\stdClass $data)
    {
        $criteria = [];
        $response = new \stdClass();
        $response->publicationOTTranscoGDIServiceOutput = new \stdClass();
        $response->publicationOTTranscoGDIServiceOutput->Reponse = [];
        $response->codeReponse = new \stdClass();

        $expectedFields = [
            TranscoAgence::CODE_AGENCE,
        ];

        if (key($data) === $this::PUBLICATION_OT) {
            $criteria = $this->extractCriteria($data);
        }

        try {
            $this->return['result'] = $this->transcoService->getPublicationOttResponse($criteria);
            $this->validationQuery($criteria, $expectedFields);
            $response->publicationOTTranscoGDIServiceOutput->Reponse = $this->return['result'];
            $response->codeReponse->codeRetour = $this->return['code'];
            $response->codeReponse->messageRetour = $this->return['message'];
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }

    /**
     * @param \stdClass $data
     * @return mixed
     * @internal param $criteria
     */
    private function extractCriteria(\stdClass $data)
    {
        $criteria = [];
        foreach (reset($data)->Critere as $key => $item) {
            if ($item->NomCritere !== '' && $item->ValeurCritere !== '') {
                $criteria[$key]['name'] = $item->NomCritere;
                $criteria[$key]['value'] = $item->ValeurCritere;
            }
        }
        return $criteria;
    }

    /**
     * @param array $criteria
     * @param $fields
     * @param null $sourceCorrect
     */
    private function validationQuery(array $criteria, $fields, $sourceCorrect = null)
    {
        $fields = $this->fieldIsNull($criteria, $fields);
        if (!empty($fields)) {
            $this->return['result'] = '';
            $this->return['message'] = "Les champs obligatoires ne sont pas remplis:" . implode($fields, ', ');
            $this->return['code'] = $this::ERROR_MISSING_FIELDS;
        } elseif ($this->return['result'] == $this::ERROR_IMPOSSIBLE_TRANSCODIFICATION) {
            $this->return['result'] = '';
            $this->return['message'] = "Transcodification impossible !";
            $this->return['code'] = $this::ERROR_IMPOSSIBLE_TRANSCODIFICATION;
        } elseif ($this->return['result'] == null || $this->return['result'] == $this::ERROR_NOT_FOUND) {
            $this->return['result'] = '';
            $this->return['message'] = "ValeurRecherchee non reconnue";
            $this->return['code'] = $this::ERROR_NOT_FOUND;
        } elseif ($sourceCorrect !== null && !$sourceCorrect) {
            $this->return['result'] = '';
            $this->return['code'] = $this::ERROR_SOURCE_INCORRECT;
            $this->return['message'] = "Valeur du critere 'Source' incorrecte";
        } else {
            $this->return['message'] = "Success";
            $this->return['code'] = "0000000000";
        }
    }

    /**
     * @param $criteria
     * @param $expectedFields
     * @return array
     */
    private function fieldIsNull($criteria, $expectedFields)
    {
        $fields = [];
        $fieldsCrit = [];
        foreach ($criteria as $crit) {
            $fieldsCrit[] = $crit['name'];
            if ($crit['value'] == null) {
                $fields[] = $crit['name'];
            }
        }
        foreach ($expectedFields as $field) {
            if (!in_array($field, $fieldsCrit)) {
                $fields[] = $field;
            }
        }
        return $fields;
    }
}
