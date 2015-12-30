<?php

namespace PortalBundle\Service\SoapService;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class TranscoNatureInterService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.exposed_ws", public=true)
 */
class ExposedWSService
{
    /**
     * @var TranscoNatureInterService
     * @DI\Inject("portal.service.transconatureinter")
     */
    public $transcoNatureInterService;


    /**
     * @DI\InjectParams({
     *     "transcoNatureInterService" = @DI\Inject("portal.service.transconatureinter"),
     * })
     * @param $transcoNatureInterService
     */
    public function __construct($transcoNatureInterService)
    {
        $this->transcoNatureInterService = $transcoNatureInterService;
    }

    /**
     * diffuserCalendrierRessource
     *
     * @param type $data
     * @return \stdClass
     */
    public function transcoGdiService($data)
    {
        $response = new \stdClass();
        $response->codeReponse = new \stdClass();

        dump($data);

        try {
            $response->codeReponse->codeRetour = 'OK';
            $response->codeReponse->messageRetour = 'Succes';
        } catch (\Exception $exception) {
            $response->codeReponse->codeRetour = 'KO';
            $response->codeReponse->messageRetour = $exception->getMessage();
        }

        return $response;
    }
}
