<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Tests\BaseWebTestCase;

class RegionControllerTest extends BaseWebTestCase
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
     * testGetAllRegionsSecuredAction
     */
    public function testGetAllRegionsSecuredAction()
    {
        $regions = $this->em->getRepository('PortalBundle:Region')->findAll();
        $this->client->request('GET', "/regions_secured", [], [], $this->headers);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($regions[0]->getCode(), $response[0]['code']);
    }
}
