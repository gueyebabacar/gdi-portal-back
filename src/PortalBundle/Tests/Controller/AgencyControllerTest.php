<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Entity\Region;
use PortalBundle\Tests\BaseWebTestCase;

class AgencyControllerTest extends BaseWebTestCase
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
     * testGetAgenciesFromRegionSecuredAction
     */
    public function testGetAgenciesFromRegionSecuredAction()
    {
        $agencies = $this->em->getRepository('PortalBundle:Agency')->findBy(['region' => '1']);

        $this->client->request('GET', "/portal/regions/1/agencies_secured", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($agencies[0]->getCode(), $response[0]['code']);
    }

    /**
     *@test  testGetAgenciesFromRegionAction
     */
    public function testGetAgenciesFromRegionAction()
    {
        $agency = $this->em->getRepository('PortalBundle:Agency')->findBy(['region' => '1']);
        $this->client->request('GET', "/portal/regions/1/agencies", [], [], $this->headers);

        $this->assertNotEmpty($agency);
    }
}
