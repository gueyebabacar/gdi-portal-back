<?php

namespace TranscoBundle\Tests\Controller;

use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Tests\BaseWebTestCase;

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

        $transcoDestTerrSite = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findAll();

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

        $transcoDestTerrSite = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findAll()[0];
        $this->client->request(
            'GET',
            "/transcodestersite/".$transcoDestTerrSite->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoDestTerrSite->getId(), $response['id']);
    }

    /**
     *testCreateAction
     */
    public function testCreateAction()
    {
        $data = array(
            'territory' => '050',
            'adressee' => 'COU13',
            'site' => 'METZ',
            'pr' => 'X',
            'idRefStructureOp' => 'ATG050',
        );

        $transcoDestTerrSite = new TranscoDestTerrSite();
        $transcoDestTerrSite->setTerritory($data['territory']);
        $transcoDestTerrSite->setAdressee($data['adressee']);
        $transcoDestTerrSite->setSite($data['site']);
        $transcoDestTerrSite->setPr($data['pr']);
        $transcoDestTerrSite->setIdRefStructureOp($data['idRefStructureOp']);

        $this->client->request(
            'POST',
            "/transcodestersite/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoDestTerrSite->getPr(), $response['pr']);
        $this->assertEquals($transcoDestTerrSite->getIdRefStructureOp(), $response['id_ref_structure_op']);
    }

    /**
     *testNewAction
     */
    public function testEditAction()
    {
        $this->insertTranscoDestTerrSite();

        $data = array(
            'id' => 1,
            'territory' => '056',
        );

        $transcoDestTerrSite = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findAll()[0];
        $transcoDestTerrSite->setTerritory($data['territory']);

        $this->client->request(
            'POST',
            "/transcodestersite/".$transcoDestTerrSite->getId()."/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoDestTerrSite->getTerritory(), $response['territory']);
    }

    /**
     *testDeleteAction
     */
    public function testDeleteAction()
    {
        $this->insertTranscoDestTerrSite();

        $transcoNatureInter = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->findAll()[0];
        $id = $transcoNatureInter->getId();
        $this->client->request(
            'GET',
            "/transcodestersite/".$id."/delete",
            [],
            [],
            $this->headers
        );
        $transcoNatureInter = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite')->find($id);

        $this->assertNull($transcoNatureInter);
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
            $transcoDestTerrSite->setTerritory('055');

            $this->em->persist($transcoDestTerrSite);
        }
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
