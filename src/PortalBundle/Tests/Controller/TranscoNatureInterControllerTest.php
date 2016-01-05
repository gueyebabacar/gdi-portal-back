<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Entity\TranscoNatureInter;
use PortalBundle\Tests\BaseWebTestCase;

class TranscoNatureInterControllerTest extends BaseWebTestCase
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

        $this->headers = ['HTTP_gaiaId' => 'AO4620', 'Content-Type' => 'multipart/form-data'];
    }

    /**
     *testGetAllAction
     */
    public function testGetAllAction()
    {
        $this->insertTranscoNatureInter();

        $transcoNatureInters = $this->em->getRepository('PortalBundle:TranscoNatureInter')->findAll();

        $this->client->request('GET', "/transconatureinter/all", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($transcoNatureInters), sizeof($response));
        $this->assertEquals($transcoNatureInters[0]->getCounter(), $response[0]['app']);
        $this->assertEquals($transcoNatureInters[0]->getId(), $response[0]['id']);
    }

    /**
     *testGetAction
     */
    public function testGetAction()
    {
        $this->insertTranscoNatureInter();

        $transcoNatureInter = $this->em->getRepository('PortalBundle:TranscoNatureInter')->findAll()[0];
        $this->client->request(
            'GET',
            "/transconatureinter/".$transcoNatureInter->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoNatureInter->getId(), $response['id']);
        $this->assertEquals($transcoNatureInter->getCounter(), $response['app']);
    }

    /**
     *testNewAction
     */
    public function testCreateAction()
    {
        $data = array(
            'id' => 1,
            'opticNatCode' => 'ROBI',
            'opticSkill' => 'Maintenance Robinet',
            'opticNatLabel' => 'Inspection robinet reseau',
            'pictrelNatOpCode' => 'AA',
            'pictrelNatLabel' => 'Inspection robinet reseau',
            'troncatedPictrelNatOpLabel' => 'Inspection robinet reseau',
            'app' => 1,
        );

        $transcoNatureInter = new TranscoNatureInter();

        $transcoNatureInter->setId($data['id']);
        $transcoNatureInter->setOpticNatCode($data['opticNatCode']);
        $transcoNatureInter->setOpticSkill($data['opticSkill']);
        $transcoNatureInter->setOpticNatLabel($data['opticNatLabel']);
        $transcoNatureInter->setPictrelNatOpCode($data['pictrelNatOpCode']);
        $transcoNatureInter->setPictrelNatOpLabel($data['pictrelNatLabel']);
        $transcoNatureInter->setTroncatedPictrelNatOpLabel($data['troncatedPictrelNatOpLabel']);
        $transcoNatureInter->setCounter($data['app']);

        $this->client->request(
            'POST',
            "/transconatureinter/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoNatureInter->getOpticNatCode(), $response['optic_nat_code']);
        $this->assertEquals($transcoNatureInter->getCounter(), $response['app']);
    }

    /**
     *testNewAction
     */
    public function testUpdateAction()
    {
        $this->insertTranscoNatureInter();

        $data = array(
            'id' => 1,
            'opticNatCode' => 'ROBO',
        );

        $transcoNatureInter = $this->em->getRepository('PortalBundle:TranscoNatureInter')->findAll()[0];
        $transcoNatureInter->setOpticNatCode($data['opticNatCode']);

        $this->client->request(
            'POST',
            "/transconatureinter/".$transcoNatureInter->getId()."/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoNatureInter->getOpticNatCode(), $response['optic_nat_code']);
    }

    /**
     *testNewAction
     */
    public function testDeleteAction()
    {
        $this->insertTranscoNatureInter();

        $transcoNatureInter = $this->em->getRepository('PortalBundle:TranscoNatureInter')->findAll()[0];
        $id = $transcoNatureInter->getId();
        $this->client->request(
            'GET',
            "/transconatureinter/".$id."/delete",
            [],
            [],
            $this->headers
        );
        $transcoNatureInter = $this->em->getRepository('PortalBundle:TranscoNatureInter')->find($id);

        $this->assertNull($transcoNatureInter);
    }

    /**
     *insertTranscoNatureInter
     */
    private function insertTranscoNatureInter()
    {
        for ($i = 0; $i < 2; $i++) {

            $transcoNatureInter = new TranscoNatureInter();

            $transcoNatureInter->setOpticNatCode('AAA');
            $transcoNatureInter->setOpticSkill('lorem ipsum');
            $transcoNatureInter->setOpticNatLabel('lorem ipsum');
            $transcoNatureInter->setPictrelNatOpCode('lorem ipsum');
            $transcoNatureInter->setPictrelNatOpLabel('lorem ipsum');
            $transcoNatureInter->setTroncatedPictrelNatOpLabel('lorem ipsum');
            $transcoNatureInter->setCounter($i);

            $this->em->persist($transcoNatureInter);
        }
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
