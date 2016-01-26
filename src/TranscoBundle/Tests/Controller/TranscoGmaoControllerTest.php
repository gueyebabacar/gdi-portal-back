<?php

namespace TranscoBundle\Tests\Controller;

use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoGmaoControllerTest extends BaseWebTestCase
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
     * testGetAllAction
     *
     * @test
     * @group transco
     */
    public function testGetAllAction()
    {
        $this->insertTranscoGmao();

        $transcoGmao = $this->em->getRepository('TranscoBundle:TranscoGmao')->findAll();

        $this->client->request('GET', "/transcogmao/all", [], [], $this->headers);
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($transcoGmao), sizeof($response));
        $this->assertEquals($transcoGmao[0]->getId(), $response[0]['id']);
    }

    /**
     * testGetAction
     *
     * @test
     * @group transco
     */
    public function testGetAction()
    {
        $this->insertTranscoGmao();

        $transcoGmao = $this->em->getRepository('TranscoBundle:TranscoGmao')->findAll()[0];

        $this->client->request(
            'GET',
            "/transcogmao/" . $transcoGmao->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoGmao->getCounter(), $response['counter']);
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
            'workType' => 'work type',
            'groupGame' => 'group de gamme',
            'counter' => 1,
        );

        $transcoGmao = new TranscoGmao();
        $transcoGmao->setWorkType($data['workType']);
        $transcoGmao->setGroupGame($data['groupGame']);
        $transcoGmao->setCounter($data['counter']);

        $this->client->request(
            'POST',
            "/transcogmao/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);


        $this->assertEquals($transcoGmao->getWorkType(), $response['work_type']);

    }

    /**
     * testNewAction
     *
     * @test
     * @group transco
     */
    public function testEditAction()
    {
        $this->insertTranscoGmao();

        $data = array(

            'workType' => 'work type',
        );

        $transcoGmao = $this->em->getRepository('TranscoBundle:TranscoGmao')->findAll()[0];
        $transcoGmao->setWorkType($data['workType']);

        $this->client->request(
            'POST',
            "/transcogmao/" . $transcoGmao->getId() . "/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoGmao->getWorkType(), $response['work_type']);
    }

    /**
     * testDeleteAction
     *
     * @test
     * @group transco
     */
    public function testDeleteAction()
    {
        $this->markTestSkipped();

        $this->insertTranscoGmao();

        $transcoGmao = $this->em->getRepository('TranscoBundle:TranscoGmao')->findAll()[0];
        $id = $transcoGmao->getId();
        $this->client->request(
            'GET',
            "/transcogmao/" . $id . "/delete",
            [],
            [],
            $this->headers
        );
        $transcoGmao = $this->em->getRepository('TranscoBundle:TranscoGmao')->find($id);

        $this->assertNull($transcoGmao);
    }

    /**
     * insertTranscoGmao
     */
    public function insertTranscoGmao()
    {
        for ($i = 0; $i < 2; $i++)
        {
            $transcoGmao = new TranscoGmao();

            $transcoGmao->setWorkType('work type');
            $transcoGmao->setGroupGame('lorem xxx14');
            $transcoGmao->setCounter(10);

            $this->em->persist($transcoGmao);
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
