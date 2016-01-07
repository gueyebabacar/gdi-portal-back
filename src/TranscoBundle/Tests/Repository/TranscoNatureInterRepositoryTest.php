<?php

namespace TranscoBundle\Tests\Repository;

use TranscoBundle\Entity\TranscoNatureInter;
use TranscoBundle\Repository\TranscoNatureInterRepository;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoNatureInterRepositoryTest extends BaseWebTestCase
{
    /**
     * @var TranscoNatureInterRepository
     */
    protected $transcoNatureInterRepo;

    public function setUp()
    {
        parent::setUp();
        $this->transcoNatureInterRepo = $this->em->getRepository('TranscoBundle:TranscoNatureInter');
    }

    public function testfindCodeNatIntFromCodeNatOp()
    {
        $data['criteria'][0]['value'] = "NATOPCODE";
        $this->insertTranscoNatureInter();
        $result = $this->transcoNatureInterRepo->findCodeNatIntFromCodeNatOp($data);
        $this->assertEquals(reset($result[0]), 'AAA');
    }

    public function testfindCodeNatopFromCodeNatInt()
    {
        $data['criteria'][0]['value'] = "AAA";
        $this->insertTranscoNatureInter();
        $result = $this->transcoNatureInterRepo->findCodeNatopFromCodeNatInt($data);
        $this->assertEquals(reset($result[0]), "NATOPCODE");
    }

    /**
     *insertTranscoNatureInter
     */
    private function insertTranscoNatureInter()
    {
        $transcoNatureInter = new TranscoNatureInter();

        $transcoNatureInter->setOpticNatCode('AAA');
        $transcoNatureInter->setOpticSkill('optic skill');
        $transcoNatureInter->setOpticNatLabel('optic nat label');
        $transcoNatureInter->setPictrelNatOpCode('NATOPCODE');
        $transcoNatureInter->setPictrelNatOpLabel('nat op label');
        $transcoNatureInter->setTroncatedPictrelNatOpLabel('troncated nat op label');
        $transcoNatureInter->setCounter(0);

        $this->em->persist($transcoNatureInter);
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
