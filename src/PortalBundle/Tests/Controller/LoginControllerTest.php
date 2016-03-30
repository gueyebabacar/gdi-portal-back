<?php

namespace PortalBundle\Tests\Controller;

use PortalBundle\Tests\BaseWebTestCase;

class LoginControllerTest extends BaseWebTestCase
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
     * @test
     * testWhoAmIAction
     */
    public function testWhoAmIAction()
    {
        $this->client->request('GET', "/portal/user/whoami", [], [], $this->headers);
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('GAIA10', $response['user']['gaia']);
    }
}
