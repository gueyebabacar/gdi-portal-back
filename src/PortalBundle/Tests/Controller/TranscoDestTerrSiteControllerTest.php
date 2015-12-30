<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Entity\TranscoDestTerrSite;
use PortalBundle\Tests\BaseWebTestCase;

class TranscoDestTerrSiteControllerTest extends BaseWebTestCase
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
        $this->insertTranscoDestTerrSite();

        $transcoDestTerrSite = $this->em->getRepository('PortalBundle:TranscoDestTerrSite')->findAll();

        $this->client->request('GET', "/transcodestersite/all", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($transcoDestTerrSite), sizeof($response));
        $this->assertEquals($transcoDestTerrSite[0]->getId(), $response[0]['id']);
    }

    /**
     *
     */
    public function testGetAction()
    {
        $this->insertTranscoDestTerrSite();

        $transcoDestTerrSite = $this->em->getRepository('PortalBundle:TranscoDestTerrSite')->findAll()[0];
        $this->client->request(
            'GET',
            "/transconatureinter/".$transcoDestTerrSite->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoDestTerrSite->getId(), $response['id']);
    }

    /*
     *
     */
    public function testCreateAction()
    {
        $this->insertTranscoDestTerrSite();

        $transcoDestTerrSite = $this->em->getRepository('PortalBundle:TranscoDestTerrSite')->findAll()[0];
        $this->client->request(
            'GET',
            "/transconatureinter/".$transcoDestTerrSite->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoDestTerrSite->getId(), $response['id']);
        $this->assertEquals($transcoDestTerrSite->getIdRefStructureOp(), $response['idRefStructureOp']);
    }

    /**
     *
     */
    public function insertTranscoDestTerrSite()
    {
        for ($i = 0; $i < 2; $i++) {

            $transcoDestTerrSite = new TranscoDestTerrSite();

            $transcoDestTerrSite->setIdRefStructureOp(254);
            $transcoDestTerrSite->setSite('lorem ipsum');
            $transcoDestTerrSite->setAdressee('lorem ipsum');
            $transcoDestTerrSite->setSite('lorem ipsum');
            $transcoDestTerrSite->setPr('lorem ipsum');

            $this->em->persist($transcoDestTerrSite);
        }
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
