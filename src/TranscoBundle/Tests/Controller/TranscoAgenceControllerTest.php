<?php

namespace TranscoBundle\Tests\Controller;

use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoAgenceControllerTest extends BaseWebTestCase
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
        $this->insertTranscoAgence();

        $transcoAgence = $this->em->getRepository('TranscoBundle:TranscoAgence')->findAll();

        $this->client->request('GET', "/transcoagence/all", [], [], $this->headers);
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($transcoAgence), sizeof($response));
        $this->assertEquals($transcoAgence[0]->getId(), $response[0]['id']);
    }

    /**
     * testGetAction
     *
     * @test
     * @group transco
     */
    public function testGetAction()
    {
        $this->insertTranscoAgence();

        $transcoAgence = $this->em->getRepository('TranscoBundle:TranscoAgence')->findAll()[0];

        $this->client->request(
            'GET',
            "/transcoagence/" . $transcoAgence->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoAgence->getId(), $response['id']);
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
            'inseeCode' => 'code insee',
            'codeAgence' => 'code agence',
            'agenceLabel' => 'label agence',
            'center' => 'centre',
            'destinataire' => 'destinataire',
            'pr' => 'pr',
        );

        $transcoAgence = new TranscoAgence();
        $transcoAgence->setInseeCode($data['inseeCode']);
        $transcoAgence->setCodeAgence($data['codeAgence']);
        $transcoAgence->setAgenceLabel($data['agenceLabel']);
        $transcoAgence->setCenter($data['center']);
        $transcoAgence->setDestinataire($data['destinataire']);
        $transcoAgence->setPr($data['pr']);

        $this->client->request(
            'POST',
            "/transcoagence/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals($transcoAgence->getPr(), $response['pr']);

    }

    /**
     * testNewAction
     *
     * @test
     * @group transco
     */
    public function testEditAction()
    {
        $this->insertTranscoAgence();

        $data = array(

            'destinataire' => 'adressee',
        );

        $transcoAgence = $this->em->getRepository('TranscoBundle:TranscoAgence')->findAll()[0];
        $transcoAgence->setDestinataire($data['destinataire']);

        $this->client->request(
            'POST',
            "/transcoagence/" . $transcoAgence->getId() . "/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoAgence->getDestinataire(), $response['destinataire']);
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

        $this->insertTranscoAgence();

        $transcoAgence = $this->em->getRepository('TranscoBundle:TranscoAgence')->findAll()[0];
        $id = $transcoAgence->getId();
        $this->client->request(
            'GET',
            "/transcoagence/" . $id . "/delete",
            [],
            [],
            $this->headers
        );
        $transcoAgence = $this->em->getRepository('TranscoBundle:TranscoAgence')->find($id);

        $this->assertNull($transcoAgence);
    }

    /**
     * insertTranscoAgence
     *
     * @test
     * @group transco
     */
    public function insertTranscoAgence()
    {
        for ($i = 0; $i < 2; $i++)
        {
            $transcoAgence = new TranscoAgence();

            $transcoAgence->setInseeCode('254');
            $transcoAgence->setCodeAgence('lorem xxx14');
            $transcoAgence->setAgenceLabel('lorem ipsum');
            $transcoAgence->setCenter('lorem');
            $transcoAgence->setDestinataire('lorem');
            $transcoAgence->setPr('lorem ipsum');

            $this->em->persist($transcoAgence);
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
