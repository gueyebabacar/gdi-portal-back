<?php

namespace TranscoBundle\Tests\Repository;

use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Repository\TranscoAgenceRepository;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoAgenceRepositoryTest extends BaseWebTestCase
{
    /**
     * @var TranscoAgenceRepository
     */
    protected $transcoAgenceRepository;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();
        $this->transcoAgenceRepository = $this->em->getRepository('TranscoBundle:TranscoAgence');
    }

    /**
     * @test
     * @group transco
     * testFindEnvoiDirgAgenceRequest
     */
    public function testFindEnvoiDirgAgenceRequest()
    {
        $criteria = [
            [
                "name" => "CodeAgence",
                "value" => "Ck14"
            ],
            [
                "name" => "CodeInsee",
                "value" => "XO7A"
            ],
        ];
        $this->insertTranscoAgence();
        $result = $this->transcoAgenceRepository->findEnvoiDirgAgenceRequest($criteria);
        $this->assertEquals('NEUILLY', $result[0]['destinataire']);
        $this->assertEquals('ATG254', $result[0]['center']);
    }

    /**
     * @test
     * @group transco
     * testFindPublicationOtRequest
     */
    public function testFindPublicationOtRequest()
    {
        $criteria = [
            [
                "name" => "CodeAgence",
                "value" => "Ck14"
            ]
        ];
        $this->insertTranscoAgence();
        $result = $this->transcoAgenceRepository->findPublicationOtRequest($criteria);
        $this->assertEquals('X', $result[0]['pr']);
    }

    /**
     *insertTranscoNatureInter
     */
    private function insertTranscoAgence()
    {
        $data = array(
            'inseeCode' => 'XO7A',
            'codeAgence' => 'Ck14',
            'agenceLabel' => 'CONDORCET',
            'center' => 'ATG254',
            'destinataire' => 'NEUILLY',
            'pr' => 'X',
        );

        $transcoAgence = new TranscoAgence();

        $transcoAgence->setInseeCode($data['inseeCode']);
        $transcoAgence->setCodeAgence($data['codeAgence']);
        $transcoAgence->setAgenceLabel($data['agenceLabel']);
        $transcoAgence->setCenter($data['center']);
        $transcoAgence->setDestinataire($data['destinataire']);
        $transcoAgence->setPr($data['pr']);

        $this->em->persist($transcoAgence);
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
