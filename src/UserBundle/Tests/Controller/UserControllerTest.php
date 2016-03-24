<?php

namespace UserBundle\Tests\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Tests\BaseWebTestCase;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;

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
        $this->headers = ['HTTP_gaiaId' => 'GAIA10'];
    }

    /**
     *
     */
    public function testGetAllAction()
    {
        $this->insertUser();

        $user = $this->em->getRepository('UserBundle:User')->findAll();

        $this->client->request('GET', "/portal/users", [], [], $this->headers);

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
            "/portal/users/" . $transcoDestTerrSite->getId(),
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
            'entity' => 'APPI',
            'email' => 'email@email.fr',
            'username' => 'GAIA00',
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
            "/portal/users",
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($user->getFirstName(), $response['result']['first_name']);
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

        $user = $this->em->getRepository('UserBundle:User')->findAll()[0];
        $user->setFirstName($data['firstName']);

        $this->client->request(
            'PATCH',
            "/portal/users/" . $user->getId(),
            $data,
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($user->getFirstName(), $response['result']['first_name']);
    }

    /**
     *testDeleteAction
     */
    public function testDeleteAction()
    {
        $this->insertUser();

        $user = $this->em->getRepository('UserBundle:User')->findAll()[0];
        $id = $user->getId();
        $this->client->request(
            'DELETE',
            "/portal/users/" . $id,
            [],
            [],
            $this->headers
        );

        $user = $this->em->getRepository('UserBundle:User')->find($id);

        $this->assertNull($user);
    }

    /**
     *testGetProfiles
     */
    public function testGetProfiles()
    {
        /** @var ArrayCollection|User $profiles */
        $profiles =  $this->em->getRepository('UserBundle:User')->getProfiles();
        $this->client->request(
            'GET',
            "/portal/profiles",
            [],
            [],
            $this->headers
        );
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(sizeof($profiles), sizeof($response));
        $this->assertEquals($profiles[0]['firstName'], $response[0]['firstName']);
        $this->assertEquals($profiles[0]['lastName'], $response[0]['lastName']);
        $this->assertEquals($profiles[0]['username'], $response[0]['username']);
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
            'entity' => 'APPI',
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
