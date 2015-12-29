<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Entity\TranscoNatureOpe;
use PortalBundle\Tests\BaseWebTestCase;

class TranscoNatureOpeControllerTest extends BaseWebTestCase
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
        $this->insertTranscoNatureOpe();

        $transcoNatureOpes = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->findAll();

        $this->client->request('GET', "/transconatureope/all", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($transcoNatureOpes), sizeof($response));
        $this->assertEquals($transcoNatureOpes[0]->getCounter(), $response[0]['counter']);
        $this->assertEquals($transcoNatureOpes[0]->getId(), $response[0]['id']);
    }

    /**
     *testGetAction
     */
    public function testGetAction()
    {
        $this->insertTranscoNatureOpe();

        $transcoNatureOpe = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->findAll()[0];
        $this->client->request(
            'GET',
            "/transconatureope/".$transcoNatureOpe->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoNatureOpe->getId(), $response['id']);
        $this->assertEquals($transcoNatureOpe->getCounter(), $response['counter']);
        $this->assertEquals($transcoNatureOpe->getNatureInterCode(), $response['nature_inter_code']);

    }

    /**
     *testNewAction
     */
    public function testNewAction()
    {
        $data = array(
            'id' => 1,
            'workType' => 'ROBI',
            'gammeGroup' => 'Maintenance Robinet',
            'purpose' => 'Inspection robinet reseau',
            'Counter' => 'AA',
            'segmentationValue' => 'Inspection robinet reseau',
            'segmentationName' => 'Inspection robinet reseau',
            'programmingMode' => 'Inspection robinet reseau',
            'natureInterCode' => 'Inspection robinet reseau',
        );

        $transcoNatureOpe = new TranscoNatureOpe();

        $transcoNatureOpe->setId($data['id']);
        $transcoNatureOpe->setWorkType($data['workType']);
        $transcoNatureOpe->setGammeGroup($data['gammeGroup']);
        $transcoNatureOpe->setPurpose($data['purpose']);
        $transcoNatureOpe->setCounter($data['Counter']);
        $transcoNatureOpe->setSegmentationValue($data['segmentationValue']);
        $transcoNatureOpe->setSegmentationName($data['segmentationName']);
        $transcoNatureOpe->setProgrammingMode($data['programmingMode']);
        $transcoNatureOpe->setNatureInterCode($data['natureInterCode']);

        $this->client->request(
            'POST',
            "/transconatureope/new",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoNatureOpe->getNatureInterCode(), $response['nature_inter_code']);
        $this->assertEquals($transcoNatureOpe->getCounter(), $response['counter']);
    }

    /**
     *testNewAction
     */
    public function testEditAction()
    {
        $this->insertTranscoNatureOpe();

        $data = array(
            'id' => 1,
            'natureInterCode' => 'CALOU',
        );

        $transcoNatureOpe = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->findAll()[0];
        $transcoNatureOpe->setNatureInterCode($data['natureInterCode']);

        $this->client->request(
            'POST',
            "/transconatureope/".$transcoNatureOpe->getId()."/edit",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoNatureOpe->getNatureInterCode(), $response['nature_inter_code']);
    }

    /**
     *testNewAction
     */
    public function testDeleteAction()
    {
        $this->insertTranscoNatureOpe();

        $transcoNatureOpe = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->findAll()[0];
        $id = $transcoNatureOpe->getId();
        $this->client->request(
            'GET',
            "/transconatureope/".$id."/delete",
            [],
            [],
            $this->headers
        );
        $transcoNatureOpe = $this->em->getRepository('PortalBundle:TranscoNatureOpe')->find($id);

        $this->assertNull($transcoNatureOpe);
    }

    /**
     *insertTranscoNatureOpe
     */
    public function insertTranscoNatureOpe()
    {
        for ($i = 0; $i < 2; $i++) {

            $transcoNatureOpe = new TranscoNatureOpe();

            $transcoNatureOpe->setWorkType('lorem ipsum');
            $transcoNatureOpe->setGammeGroup('lorem ipsum');
            $transcoNatureOpe->setPurpose('lorem ipsum');
            $transcoNatureOpe->setCounter($i);
            $transcoNatureOpe->setSegmentationValue('lorem ipsum');
            $transcoNatureOpe->setSegmentationName('lorem ipsum');
            $transcoNatureOpe->setProgrammingMode('lorem ipsum');
            $transcoNatureOpe->setNatureInterCode('ROBO');

            $this->em->persist($transcoNatureOpe);
        }
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
