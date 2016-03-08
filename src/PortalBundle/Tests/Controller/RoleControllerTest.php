<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Tests\BaseWebTestCase;
use UserBundle\Enum\RolesEnum;

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
        $this->headers = ['HTTP_gaiaId' => 'GAIA10'];
    }

    /**
     * testGetAllRolesAction
     */
    public function testGetAllRolesAction()
    {
        $roles= RolesEnum::getRoles();

        $this->client->request('GET', "/roles", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($roles, $response);
    }
    /**
     * testGetAllRegionsSecuredAction
     */
    public function testGetRolesSecured()
    {
        $this->client->request('GET', "/roles_secured", [], [], $this->headers);
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(RolesEnum::ROLE_VISITEUR, $response[0][0]);
        $this->assertEquals(RolesEnum::ROLE_TECHNICIEN, $response[1][0]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR, $response[2][0]);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR_AVANCE, $response[3][0]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_APPO, $response[4][0]);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_ATG, $response[5][0]);
        $this->assertEquals(RolesEnum::ROLE_REFERENT_EQUIPE, $response[6][0]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_LOCAL, $response[7][0]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL, $response[8][0]);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_SI, $response[9][0]);
    }
}
