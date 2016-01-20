<?php

namespace TranscoBundle\Tests\Controller;

use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Entity\TranscoOptic;
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
     * testInterfaceServiceTranscoActionSuccess
     *
     * @test
     * @group transco
     */
    public function testInterfaceServiceTranscoActionSuccess()
    {
        $this->markTestSkipped();
        $this->insertData();

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
     * insertData
     */
    private function insertData()
    {
        $transcoOptic = new TranscoOptic();

        $transcoOptic->setCodeNatInter('CodeNatInter');
        $transcoOptic->setProgrammingMode('ProgrammingMode');
        $transcoOptic->setCalibre('Calibre');
        $transcoOptic->setShortLabel('ShortLabel');
        $transcoOptic->setCodeTypeOptic('CodeTypeOptic');
        $transcoOptic->setFinalCode('FinalCode');
        $transcoOptic->setLabelNatInter('LabelNatInter');
        $transcoOptic->setSegmentationCode('SegmentationCode');
        $transcoOptic->setSegmentationLabel('SegmentationLabel');
        $transcoOptic->setOpticLabel('OpticLabel');
        $transcoOptic->setFinalLabel('FinalLabel');

        $transcoGmao = new TranscoGmao();
        $transcoGmao->setWorkType('WorkType');
        $transcoGmao->setGroupGame('GroupeDeGamme');
        $transcoGmao->setCounter('Counter');
        $transcoGmao->setOptic($transcoOptic);

        $transcoDisco = new TranscoDisco();

        $transcoDisco->setCodeObject('codeObject');
        $transcoDisco->setNatOp('natOp');
        $transcoDisco->setNatOpLabel('natOpLabel');
        $transcoDisco->setOptic($transcoOptic);

        $transcoOptic->addGmao($transcoGmao);
        $transcoOptic->setDisco($transcoDisco);

        $transcoAgence = new TranscoAgence();

        $transcoAgence->setInseeCode('CodeInsee');
        $transcoAgence->setCodeAgence('CodeAgence');
        $transcoAgence->setAgenceLabel('AgenceLabel');
        $transcoAgence->setCenter('Center');
        $transcoAgence->setDestinataire('Dest');
        $transcoAgence->setPr('Pr');

        $this->em->persist($transcoAgence);
        $this->em->persist($transcoDisco);
        $this->em->persist($transcoGmao);
        $this->em->persist($transcoOptic);

        $this->em->flush();
    }
}
