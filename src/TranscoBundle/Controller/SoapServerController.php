<?php

namespace TranscoBundle\Controller;

use TranscoBundle\Service\SoapService\ExposedWSService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\DiExtraBundle\Annotation as DI;

class SoapServerController extends Controller
{
    /**
     * @var ExposedWSService
     * @DI\Inject("portal.service.exposed_ws")
     */
    public $exposedSoapService;

    /**
     * @ApiDoc()
     * interfaceServiceTranscoAction controller
     * @Route("/soap/service-transco", name="interfaceServiceTransco")
     */
    public function interfaceServiceTranscoAction()
    {
        $exposedWsdls = $this->container->getParameter('exposed_wsdls');
        $wsdl = $exposedWsdls['serviceTransco']['filePath'];
        $server = new \SoapServer($wsdl, ['features' => SOAP_SINGLE_ELEMENT_ARRAYS]);
        $server->setObject($this->exposedSoapService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}