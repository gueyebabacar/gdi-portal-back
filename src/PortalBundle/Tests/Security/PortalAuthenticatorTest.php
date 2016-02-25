<?php

namespace PortalBundle\Tests\Security;

use Doctrine\ORM\EntityManager;
use PortalBundle\Tests\BaseWebTestCase;

class PortalAuthenticatorTest extends BaseWebTestCase
{
    /**
     * Service manager.
     * @var EntityManager
     */
    protected $em;

    /**
     * @var array
     */
    protected $headers;

    /**
     * SetUp
     */
    protected function setup()
    {
        parent::setup();
        $this->headers = ['HTTP_gaiaId' => 'GAIA10'];
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     * @group portalAuthenticationTest
     */
    public function testAuthenticationSuccess()
    {
        $this->client->request('get', '/portal/users', [], [], $this->headers);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @group gdiAuthenticationTest
     */
    public function testAuthenticationFail()
    {
        $this->client->request('get', '/portal/users', [], [], []);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }
}
