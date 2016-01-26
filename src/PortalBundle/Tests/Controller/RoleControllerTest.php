<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Entity\Role;
use PortalBundle\Tests\BaseWebTestCase;

class RoleControllerTest extends BaseWebTestCase
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
        $this->insertRole();

        $roles= $this->em->getRepository('PortalBundle:Role')->findAll();
        $this->client->request('GET', "/role/all", [], [], $this->headers);
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($roles), sizeof($response));
        $this->assertEquals($roles[0]->getCode(), $response[0]['code']);
    }

    /**
     *testGetAction
     */
    public function testGetAction()
    {
        $this->insertRole();

        $role = $this->em->getRepository('PortalBundle:Role')->findAll()[0];
        $this->client->request(
            'GET',
            "/role/".$role->getId(),
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($role->getId(), $response['id']);
    }

    /**
     *testNewAction
     */
    public function testCreateAction()
    {
        $data = array(
            'id' => 1,
            'label' => 'Programmateur',
            'code' => 'PROGRAMMATEUR',
        );

        $role = new Role();

        $role->setId($data['id']);
        $role->setLabel($data['label']);
        $role->setCode($data['code']);

        $this->client->request(
            'POST',
            "/role/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($role->getCode(), $response['code']);

    }

    /**
     *testNewAction
     */
    public function testUpdateAction()
    {
        $this->insertRole();

        $data = array(
            'label' => 'Technicien',
        );

        $role = $this->em->getRepository('PortalBundle:Role')->findAll()[0];
        $role->setLabel($data['label']);

        $this->client->request(
            'POST',
            "/role/".$role->getId()."/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($role->getLabel(), $response['label']);
    }

    /**
     *testNewAction
     */
    public function testDeleteAction()
    {
        $this->markTestSkipped();
        $this->insertRole();

        $role = $this->em->getRepository('PortalBundle:Role')->findAll()[0];
        $id = $role->getId();
        $this->client->request(
            'GET',
            "/role/".$id."/delete",
            [],
            [],
            $this->headers
        );

    }

    /**
     * insert on role table
     */
    private function insertRole()
    {
        for ($i = 0; $i < 2; $i++) {

            $role = new Role();
            $role->setLabel('Programmateur');
            $role->setCode('PROGRAMMATEUR');

            $this->em->persist($role);
        }
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
