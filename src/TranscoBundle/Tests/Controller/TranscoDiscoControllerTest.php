<?php

namespace TranscoBundle\Tests\Controller;

use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoDiscoControllerTest extends BaseWebTestCase
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
        $this->insertTranscoDisco();

        $transcoDisco = $this->em->getRepository('TranscoBundle:TranscoDisco')->findAll();

        $this->client->request('GET', "/transcodisco/all", [], [], $this->headers);
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(sizeof($transcoDisco), sizeof($response));
        $this->assertEquals($transcoDisco[0]->getId(), $response[0]['id']);
    }

    /**
     * testGetAction
     *
     * @test
     * @group transco
     */
    public function testGetAction()
    {
        $this->insertTranscoDisco();

        $transcoDisco = $this->em->getRepository('TranscoBundle:TranscoDisco')->findAll()[0];

        $this->client->request(
            'GET',
            "/transcodisco/" . $transcoDisco->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoDisco->getId(), $response['id']);
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
            'codeObject' => 'code object',
            'natOp' => 'code agence',
            'natOpLabel' => 'label agence',
        );

        $transcoDisco = new TranscoDisco();
        $transcoDisco->setCodeObject($data['codeObject']);
        $transcoDisco->setNatOp($data['natOp']);
        $transcoDisco->setNatOpLabel($data['natOpLabel']);

        $this->client->request(
            'POST',
            "/transcodisco/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals($transcoDisco->getCodeObject(), $response['code_object']);

    }

    /**
     * testNewAction
     *
     * @test
     * @group transco
     */
    public function testEditAction()
    {
        $this->insertTranscoDisco();

        $data = array(

            'natOp' => 'nature operation',
        );

        $transcoDisco = $this->em->getRepository('TranscoBundle:TranscoDisco')->findAll()[0];
        $transcoDisco->setNatOp($data['natOp']);

        $this->client->request(
            'POST',
            "/transcodisco/" . $transcoDisco->getId() . "/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($transcoDisco->getNatOp(), $response['nat_op']);
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

        $this->insertTranscoDisco();

        $transcoDisco = $this->em->getRepository('TranscoBundle:TranscoDisco')->findAll()[0];
        $id = $transcoDisco->getId();
        $this->client->request(
            'GET',
            "/transcodisco/" . $id . "/delete",
            [],
            [],
            $this->headers
        );
        $transcoDisco = $this->em->getRepository('TranscoBundle:TranscoDisco')->find($id);

        $this->assertNull($transcoDisco);
    }

    /**
     * insertTranscoDisco
     */
    public function insertTranscoDisco()
    {
        for ($i = 0; $i < 2; $i++)
        {
            $transcoDisco = new TranscoDisco();

            $transcoDisco->setCodeObject('254');
            $transcoDisco->setNatOp('lorem xxx14');
            $transcoDisco->setNatOpLabel('lorem ipsum');

            $this->em->persist($transcoDisco);
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
