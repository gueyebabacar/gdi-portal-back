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
     *
     */
    public function testGetAllAction()
    {
        $this->insertTranscoNatureInter();

        $transcoNatureInters = $this->em->getRepository('PortalBundle:TranscoNatureInter')->findAll();

        $this->client->request('GET', "/transconatureinter/all", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($transcoNatureInters), sizeof($response));
        $this->assertEquals($transcoNatureInters[0]->getApp(), $response[0]['app']);
        $this->assertEquals($transcoNatureInters[0]->getId(), $response[0]['id']);
    }

    /**
     *
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
        $this->assertEquals($transcoNatureInter->getApp(), $response['app']);
    }

    /*
     *
     */
    public function testCreateAction()
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
        $this->assertEquals($transcoNatureInter->getApp(), $response['app']);
    }

    /**
     *
     */
    public function insertTranscoNatureInter()
    {
        for ($i = 0; $i < 2; $i++) {

            $transcoNatureInter = new TranscoNatureInter();

            $transcoNatureInter->setOpticNatCode('AAA');
            $transcoNatureInter->setOpticSkill('lorem ipsum');
            $transcoNatureInter->setOpticNatLabel('lorem ipsum');
            $transcoNatureInter->setPictrelNatOpCode('lorem ipsum');
            $transcoNatureInter->setPictrelNatOpLabel('lorem ipsum');
            $transcoNatureInter->setTroncatedPictrelNatOpLabel('lorem ipsum');
            $transcoNatureInter->setApp($i);

            $this->em->persist($transcoNatureInter);
        }
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
