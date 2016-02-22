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
        $this->assertEquals(RolesEnum::ROLE_VISITEUR_LABEL, $response[0]['label']);
        $this->assertEquals(RolesEnum::ROLE_TECHNICIEN_LABEL, $response[1]['label']);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR_LABEL, $response[2]['label']);
        $this->assertEquals(RolesEnum::ROLE_PROGRAMMATEUR_AVANCE_LABEL, $response[3]['label']);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_APPO_LABEL, $response[4]['label']);
        $this->assertEquals(RolesEnum::ROLE_MANAGER_ATG_LABEL, $response[5]['label']);
        $this->assertEquals(RolesEnum::ROLE_REFERENT_EQUIPE_LABEL, $response[6]['label']);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_LOCAL_LABEL, $response[7]['label']);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL_LABEL, $response[8]['label']);
        $this->assertEquals(RolesEnum::ROLE_ADMINISTRATEUR_SI_LABEL, $response[9]['label']);
    }
}
