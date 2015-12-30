<?php

namespace PortalBundle\Service\SoapService;

use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Service\TranscoNatureOpeService;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class TranscoNatureOpeService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.exposed_ws", public=true)
 */
class ExposedWSService
{
    /**
     * @var TranscoNatureOpeService
     * @DI\Inject("portal.service.transconatureope")
     */
    public $transcoNatureOpeService;

    /**
     * @DI\InjectParams({
     *     "transcoNatureOpeService" = @DI\Inject("portal.service.transconatureope"),
     * })
     * @param $transcoNatureOpeService
     */
    public function __construct($transcoNatureOpeService)
    {
        $this->transcoNatureOpeService = $transcoNatureOpeService;
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
