<?php

namespace TranscoBundle\Tests\Repository;

use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Repository\TranscoDestTerrSiteRepository;
use TranscoBundle\Repository\TranscoDiscoRepository;
use TranscoBundle\Service\SoapService\ExposedWSService;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoDiscoRepositoryTest extends BaseWebTestCase
{
    /**
     * @var TranscoDiscoRepository
     */
    private $transcoDiscoRepo;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();
        $this->transcoDiscoRepo = $this->em->getRepository('TranscoBundle:TranscoDisco');
    }

    /**
     * @test
     * @group transco
     * testFindEnvoiDirgDiscoRequest
     */
    public function testFindEnvoiDirgDiscoRequest()
    {
        $criteria = [
            [
                "name" => "CodeNatureIntervention",
                "value" => "CodeNatInter"
            ],
            [
                "name" => "CodeFinalite",
                "value" => "FinalCode"
            ],
            [
                "name" => "CodeSegmentation",
                "value" => "SegmentationCode"
            ],
        ];
        $this->insertTranscoDisco();
        $result = $this->transcoDiscoRepo->findEnvoiDirgDiscoRequest($criteria);
        $this->assertEquals('natOp', $result[0]['natOp']);
        $this->assertEquals('codeObject', $result[0]['codeObject']);
    }



    /**
     *insertTranscoDestTerrSite
     */
    private function insertTranscoDisco()
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

        $transcoDisco = new TranscoDisco();

        $transcoDisco->setCodeObject('codeObject');
        $transcoDisco->setNatOp('natOp');
        $transcoDisco->setNatOpLabel('natOpLabel');
        $transcoDisco->setOptic($transcoOptic);

        $this->em->persist($transcoDisco);
        $this->em->persist($transcoOptic);
        $this->em->flush();
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}