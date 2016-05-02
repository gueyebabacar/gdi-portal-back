<?php

namespace PortalBundle\Tests\Security;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Security\UserProvider;
use PortalBundle\Security\PortalAuthenticator;
use PortalBundle\Tests\BaseWebTestCase;
use Prophecy\Prophet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use UserBundle\Entity\User;

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
     * @var PortalAuthenticator
     */
    protected $portalAuthenticator;

    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * SetUp
     */
    protected function setup()
    {
        parent::setup();
        $this->prophet = new Prophet();
        $this->portalAuthenticator = new PortalAuthenticator();
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
        $this->client->request('get', '/portal/users', [], [], ['HTTP_gaiaId' => 'nogaia']);
        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @group security
     */
    public function testCreateTokenSuccess()
    {
        $providerKey = 'test';
        $request     = new Request();
        $request->headers->set('gaiaId', 'GAIA10');

        /** @var PreAuthenticatedToken $preAuthActual */
        $preAuthActual = $this->portalAuthenticator->createToken($request, $providerKey);

        $this->assertInstanceOf('\Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken', $preAuthActual);
        $this->assertEquals($providerKey, $preAuthActual->getProviderKey());

        $this->assertEquals('anon.', $preAuthActual->getUser());
        $this->assertEquals('GAIA10', $preAuthActual->getCredentials());
    }
}
