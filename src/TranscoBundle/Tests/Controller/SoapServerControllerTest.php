<?php

namespace TranscoBundle\Tests\Controller;

use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Tests\BaseWebTestCase;
use Symfony\Component\PropertyInfo\Type;

class SoapServerControllerTest extends BaseWebTestCase
{
    /**
     * Service manager.
     *
     * @var type
     */
    protected $soapClient;
    protected $wsdls;

    /**
     * SetUp
     */
    protected function setUp()
    {
        parent::setUp();
        $this->wsdls = $this->container->getParameter('exposed_wsdls');
        $this->client = static::createClient();
        $this->em->beginTransaction();
    }

    /**
     * @test
     * @group functional
     * @group SoapServerController
     */
    public function testInterfaceServiceTranscoActionSuccess()
    {

        $this->insertTranscoDestTerrSite();

        $wsdl = $this->wsdls['serviceTransco']['filePath'];
        $location = $this->wsdls['serviceTransco']['location'];

        $soapOptions = array(
            'wsdl_cache' => 0,
            'trace' => 1,
            'location' => $location,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS);

        $this->soapClient = new \SoapClient($wsdl, $soapOptions);

        $options = [
            'requeteTranscoGDIServiceInput' => [
                'valeurRecherchee' => 'ATG',
                'critere' => [
                    'NomCritere' => 'Destinataire',
                    'ValeurCritere' => 'DIAM'
                ]
            ],
            'env' => [
                'projet' => 'GDI',
                'echange' => 'TranscoGDIService',
                'source' => 'BURIN'
            ]
        ];
        $response = $this->soapClient->__soapCall('TranscoGDIService', array($options));
        $this->assertEquals('0000000000', $response->codeReponse->codeRetour);
        $this->assertEquals('Succes', $response->codeReponse->messageRetour);
        $this->assertEquals('ATG74', $response->reponseTranscoGDIServiceOutput->valeurTrouvee);
    }

    /**
     *insertTranscoDestTerrSite
     */
    private function insertTranscoDestTerrSite()
    {
        $transcoDestTerrSite = new TranscoDestTerrSite();

        $transcoDestTerrSite->setIdRefStructureOp('ATG0');
        $transcoDestTerrSite->setAdressee('adresse');
        $transcoDestTerrSite->setSite('site');
        $transcoDestTerrSite->setPr('PR');
        $transcoDestTerrSite->setTerritory('0');

        $this->em->persist($transcoDestTerrSite);
        $this->em->flush();
    }
}
