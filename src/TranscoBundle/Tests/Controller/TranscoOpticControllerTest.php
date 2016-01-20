<?php

namespace TranscoBundle\Tests\Controller;

use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoOpticControllerTest extends BaseWebTestCase
{
    /**
     * @var array
     */
    private $headers;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->headers = ['Content-Type' => 'multipart/form-data'];
    }

    /**
     * testGetAllAction
     *
     * @test
     * @group transco
     */
    public function testGetAllAction()
    {
        $this->insertTranscoOptic();

        $transcoOptic = $this->em->getRepository('TranscoBundle:TranscoOptic')->findAll();

        $this->client->request('GET', "/transcoptic/all", [], [], $this->headers);
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($transcoOptic), sizeof($response));
        $this->assertEquals($transcoOptic[0]->getId(), $response[0]['id']);
    }

    /**
     * testGetAction
     *
     * @test
     * @group transco
     */
    public function testGetAction()
    {
        $this->insertTranscoOptic();

        $transcoOptic = $this->em->getRepository('TranscoBundle:TranscoOptic')->findAll()[0];

        $this->client->request(
            'GET',
            "/transcoptic/" . $transcoOptic->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoOptic->getId(), $response['id']);
    }

    /**
     * testCreateAction
     *
     * @test
     * @group transco
     */
    public function testCreateAction()
    {
        $data = array(
            'codeTypeOptic' => 'code type optic',
            'opticLabel' => 'label optic',
            'codeNatInter' => 'code nat inter',
            'labelNatInter' => 'label nat inter',
            'segmentationCode' => 'segmentation code',
            'segmentationLabel' => 'segmentation label',
            'finalCode' => 'code final',
            'finalLabel' => 'label final',
            'shortLabel' => 'short label',
            'programmingMode' => 'mode de programmation',
            'calibre' => 'calibre',
        );

        $transcoOptic = new TranscoOptic();
        $transcoOptic->setCodeTypeOptic($data['codeTypeOptic']);
        $transcoOptic->setOpticLabel($data['opticLabel']);
        $transcoOptic->setCodeNatInter($data['codeNatInter']);
        $transcoOptic->setLabelNatInter($data['labelNatInter']);
        $transcoOptic->setSegmentationCode($data['segmentationCode']);
        $transcoOptic->setSegmentationLabel($data['segmentationLabel']);
        $transcoOptic->setFinalCode($data['finalCode']);
        $transcoOptic->setFinalLabel($data['finalLabel']);
        $transcoOptic->setShortLabel($data['shortLabel']);
        $transcoOptic->setProgrammingMode($data['programmingMode']);
        $transcoOptic->setCalibre($data['calibre']);

        $this->client->request(
            'POST',
            "/transcoptic/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);


        $this->assertEquals($transcoOptic->getCodeNatInter(), $response['code_nat_inter']);

    }

    /**
     * testEditAction
     *
     * @test
     * @group transco
     */
    public function testEditAction()
    {
        $this->insertTranscoOptic();

        $data = array(

            'codeNatInter' => 'code nature intervention',
        );

        $transcoOptic = $this->em->getRepository('TranscoBundle:TranscoOptic')->findAll()[0];
        $transcoOptic->setCodeNatInter($data['codeNatInter']);

        $this->client->request(
            'POST',
            "/transcoptic/" . $transcoOptic->getId() . "/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoOptic->getCodeNatInter(), $response['code_nat_inter']);
    }

    /**
     * testDeleteAction
     *
     * @test
     * @group transco
     */
    public function testDeleteAction()
    {
        $this->insertTranscoOptic();

        $transcoOptic = $this->em->getRepository('TranscoBundle:TranscoOptic')->findAll()[0];
        $id = $transcoOptic->getId();
        $this->client->request(
            'GET',
            "/transcoptic/" . $id . "/delete",
            [],
            [],
            $this->headers
        );
        $transcoOptic = $this->em->getRepository('TranscoBundle:TranscoOptic')->find($id);

        $this->assertNull($transcoOptic);
    }

    /**
     * insertTranscoOptic
     */
    public function insertTranscoOptic()
    {
        for ($i = 0; $i < 2; $i++)
        {
            $transcoOptic = new TranscoOptic();

            $transcoOptic->setCodeNatInter('lorem ipsum');
            $transcoOptic->setProgrammingMode('lorem xxx14');
            $transcoOptic->setCalibre('Lorem ipsum');
            $transcoOptic->setShortLabel('Lorem ipsum');
            $transcoOptic->setCodeTypeOptic('Lorem ipsum');
            $transcoOptic->setFinalCode('Lorem ipsum');
            $transcoOptic->setLabelNatInter('Lorem ipsum');
            $transcoOptic->setSegmentationCode('Lorem ipsum');
            $transcoOptic->setSegmentationLabel('Lorem ipsum');
            $transcoOptic->setOpticLabel('Lorem ipsum');
            $transcoOptic->setFinalLabel('Lorem ipsum');

            $this->em->persist($transcoOptic);
        }
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
