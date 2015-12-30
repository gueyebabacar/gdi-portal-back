<?php

namespace PortalBundle\Service\SoapService;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class TranscoDestTerrSiteService
 * @package PortalBundle\Service
 *
 * @DI\Service("portal.service.exposed_ws", public=true)
 */
class ExposedWSService
{
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
