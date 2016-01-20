<?php

namespace TranscoBundle\Tests\Repository;

use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Repository\TranscoOpticRepository;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoOpticRepositoryTest extends BaseWebTestCase
{
    /**
     * @var TranscoOpticRepository
     */
    private $transcoOpticRepo;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();
        $this->transcoOpticRepo = $this->em->getRepository('TranscoBundle:TranscoOptic');
    }

    /**
     * @test
     * @group transco
     * testTindAtgFromTerritoryOrAdressee
     */
    public function testFindDelegationOT()
    {
        $criteria = [
            [
                "name" => "TypeDeTravail",
                "value" => "WorkType"
            ],
            [
                "name" => "GroupDeGamme",
                "value" => "GroupeDeGamme"
            ],
            [
                "name" => "Compteur",
                "value" => "Counter"
            ],
        ];
        $this->insertTranscoOptic();
        $result = $this->transcoOpticRepo->findDelegationOT($criteria);
        $this->assertEquals('CodeNatInter', $result[0]['codeNatInter']);
        $this->assertEquals('FinalCode', $result[0]['finalCode']);
        $this->assertEquals('SegmentationCode', $result[0]['segmentationCode']);
        $this->assertEquals('ProgrammingMode', $result[0]['programmingMode']);
    }

    /**
     * @test
     * @group transco
     * testTindAtgFromTerritoryOrAdressee
     */
    public function testFindDelegationBI()
    {
        $criteria = [
            [
                "name" => "CodeNatureOperation",
                "value" => "natOp"
            ],
            [
                "name" => "CodeObjet",
                "value" => "codeObject"
            ]
        ];
        $this->insertTranscoOptic();
        $result = $this->transcoOpticRepo->findDelegationOT($criteria);
        $this->assertEquals('CodeNatInter', $result[0]['codeNatInter']);
        $this->assertEquals('FinalCode', $result[0]['finalCode']);
        $this->assertEquals('SegmentationCode', $result[0]['segmentationCode']);
        $this->assertEquals('ProgrammingMode', $result[0]['programmingMode']);
    }

    /**
     *insertTranscoOptic
     */
    private function insertTranscoOptic()
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

        $this->em->persist($transcoDisco);
        $this->em->persist($transcoGmao);
        $this->em->persist($transcoOptic);

        $this->em->flush();
    }

    /**
     * tearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}