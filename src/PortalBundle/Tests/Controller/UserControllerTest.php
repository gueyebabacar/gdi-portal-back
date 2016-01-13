<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Entity\User;
use TranscoBundle\Tests\BaseWebTestCase;

class UserControllerTest extends BaseWebTestCase
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
        $this->insertUser();

        $user = $this->em->getRepository('PortalBundle:User')->findAll();

        $this->client->request('GET', "/users/all", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(sizeof($user), sizeof($response));
        $this->assertEquals($user[0]->getId(), $response[0]['id']);
    }

    /**
     *
     */
    public function testGetAction()
    {
        $this->insertUser();

        $transcoDestTerrSite = $this->em->getRepository('PortalBundle:User')->findAll()[0];
        $this->client->request(
            'GET',
            "/users/" . $transcoDestTerrSite->getId(),
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
        $agency = new Agency();

        $data = [
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'email' => 'entity',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'entity' => 'entity',
            'territorialContext' => 'age',
            'agency' => $agency,
        ];

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setEntity($data['email']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->setTerritorialContext($data['territorialContext']);
        $user->setAgency($data['agency']);

        $this->client->request(
            'POST',
            "/users/create",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals($user->getEntity(), $response['entity']);
        $this->assertEquals($user->getFirstName(), $response['first_name']);
    }

    /**
     *testNewAction
     */
    public function testEditAction()
    {
        $this->insertUser();

        $data = array(
            'firstName' => 'firstName-3'
        );

        $user = $this->em->getRepository('PortalBundle:User')->findAll()[0];
        $user->setFirstName($data['firstName']);

        $this->client->request(
            'POST',
            "/users/" . $user->getId() . "/update",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        dump($response);
        $this->assertEquals($user->getFirstName(), $response['first_name']);
    }

    /**
     *testDeleteAction
     */
    public function testDeleteAction()
    {
        $this->insertUser();

        $transcoNatureInter = $this->em->getRepository('PortalBundle:User')->findAll()[0];
        $id = $transcoNatureInter->getId();
        $this->client->request(
            'GET',
            "/users/" . $id . "/delete",
            [],
            [],
            $this->headers
        );
        $transcoNatureInter = $this->em->getRepository('PortalBundle:User')->find($id);

        $this->assertNull($transcoNatureInter);
    }

    /**
     *
     */
    private function insertUser()
    {
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $this->em->persist($region);
        $this->em->flush();

        $agency = new Agency();
        $agency->setLabel('agence');
        $agency->setcode('ATG0');
        $agency->setRegion($region);

        $this->em->persist($agency);
        $this->em->flush();

        $data = [
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'gaia' => 'gaia',
            'email' => 'email',
            'entity' => 'entity',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'role' => 'role',
            'agency' => $agency,
            'territorialContext' => 'age',
        ];

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setEntity($data['entity']);
        $user->setGaia($data['gaia']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->setRole($data['role']);
        $user->setTerritorialContext($data['territorialContext']);
        $user->setAgency($data['agency']);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
