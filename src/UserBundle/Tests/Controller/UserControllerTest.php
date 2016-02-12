<?php

namespace UserBundle\Tests\Controller;

use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Tests\BaseWebTestCase;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;

class UserControllerTest extends BaseWebTestCase
{
    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     *
     */
    public function testGetAllAction()
    {
        $this->insertUser();
        $this->login();

        $user = $this->em->getRepository('UserBundle:User')->findAll();

        $this->client->request('GET', "/users", [], [], []);

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

        $transcoDestTerrSite = $this->em->getRepository('UserBundle:User')->findAll()[0];
        $this->client->request(
            'GET',
            "/users/" . $transcoDestTerrSite->getId(),
            [],
            [],
            []
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
        $this->login();

        $data = [
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'entity' => 'entity',
            'email' => 'email',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'territorialContext' => 'age',
            'agency' => $agency,
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
        ];

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setEntity($data['entity']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->setTerritorialContext($data['territorialContext']);
        $user->setAgency($data['agency']);
        $user->setRoles($data['roles']);

        $this->client->request(
            'POST',
            "/users",
            $data,
            [],
            []
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($user->getFirstName(), $response['first_name']);
    }

    /**
     *testNewAction
     */
    public function testEditAction()
    {
        $this->insertUser();
        $this->login();

        $data = array(
            'firstName' => 'firstName-3'
        );

        $user = $this->em->getRepository('UserBundle:User')->findAll()[0];
        $user->setFirstName($data['firstName']);

        $this->client->request(
            'PATCH',
            "/users/" . $user->getId(),
            $data,
            [],
            []
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($user->getFirstName(), $response['first_name']);
    }

    /**
     *testDeleteAction
     */
    public function testDeleteAction()
    {
        $this->insertUser();
        $this->login();

        $user = $this->em->getRepository('UserBundle:User')->findAll()[0];
        $id = $user->getId();
        $this->client->request(
            'DELETE',
            "/users/" . $id,
            [],
            [],
            []
        );

        $user = $this->em->getRepository('UserBundle:User')->find($id);

        $this->assertNull($user);
    }

    /**
     *
     */
    private function insertUser()
    {
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $agency = new Agency();
        $agency->setLabel('agence');
        $agency->setcode('ATG0');
        $agency->setRegion($region);

        $data = [
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'gaia' => 'gaia',
            'email' => 'email',
            'entity' => 'entity',
            'password' => 'password',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'agency' => $agency,
            'territorialContext' => 'age',
        ];

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setEntity($data['entity']);
        $user->setUsername($data['gaia']);
        $user->setPassword($data['password']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->setRoles($data['roles']);
        $user->setTerritorialContext($data['territorialContext']);
        $user->setAgency($data['agency']);

        $this->em->persist($region);
        $this->em->persist($agency);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
