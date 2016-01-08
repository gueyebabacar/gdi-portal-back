<?php

namespace TranscoBundle\Tests\Repository;

use TranscoBundle\Entity\TranscoNatureInter;
use TranscoBundle\Entity\TranscoNatureOpe;
use TranscoBundle\Repository\TranscoNatureInterRepository;
use TranscoBundle\Repository\TranscoNatureOpeRepository;
use TranscoBundle\Service\SoapService\ExposedWSService;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoNatureOpeRepositoryTest extends BaseWebTestCase
{
    /**
     * @var TranscoNatureOpeRepository
     */
    protected $transcoNatureOpeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->transcoNatureOpeRepo = $this->em->getRepository('TranscoBundle:TranscoNatureOpe');
    }

    public function testFindCodeNatureIntervention3()
    {
        $data['criteria'][0]['value'] = "Work Type";
        $data['criteria'][0]['name'] = TranscoNatureOpeRepository::TYPE_DE_TRAVAIL;
        $data['criteria'][1]['value'] = 1;
        $data['criteria'][1]['name'] = TranscoNatureOpeRepository::COMPTEUR;
        $data['criteria'][2]['value'] = "Gamme group";
        $data['criteria'][2]['name'] = TranscoNatureOpeRepository::GROUPE_DE_GAMME;
        $this->insertTranscoNatureOpe();
        $result = $this->transcoNatureOpeRepo->findCodeNatureIntervention3($data);
        $this->assertEquals(reset($result[0]), 'NatIntCode');
    }

    public function testFindModeProgrammation()
    {
        $data['criteria'][0]['value'] = "Work Type";
        $data['criteria'][0]['name'] = TranscoNatureOpeRepository::TYPE_DE_TRAVAIL;
        $data['criteria'][1]['value'] = 1;
        $data['criteria'][1]['name'] = TranscoNatureOpeRepository::COMPTEUR;
        $data['criteria'][2]['value'] = "Gamme group";
        $data['criteria'][2]['name'] = TranscoNatureOpeRepository::GROUPE_DE_GAMME;
        $this->insertTranscoNatureOpe();
        $result = $this->transcoNatureOpeRepo->findModeProgrammation($data);
        $this->assertEquals(reset($result[0]), 'Prog Mode');
    }

    /**
     *insertTranscoNatureInter
     */
    private function insertTranscoNatureOpe()
    {
        $transcoNatureOpe = new TranscoNatureOpe();

        $transcoNatureOpe->setWorkType('Work Type');
        $transcoNatureOpe->setGammeGroup('Gamme group');
        $transcoNatureOpe->setPurpose('Purpose');
        $transcoNatureOpe->setCounter(1);
        $transcoNatureOpe->setSegmentationValue('Seg Value');
        $transcoNatureOpe->setSegmentationName('Seg Name');
        $transcoNatureOpe->setProgrammingMode('Prog Mode');
        $transcoNatureOpe->setNatureInterCode('NatIntCode');

        $this->em->persist($transcoNatureOpe);
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
