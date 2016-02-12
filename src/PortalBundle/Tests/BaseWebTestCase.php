<?php

namespace PortalBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Process\Process;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

/**
 * Class BaseWebTestCase
 * @package PortalBundle\Tests
 */
abstract class BaseWebTestCase extends WebTestCase
{
    /**
     * @var string
     */
    protected $environment = 'test';

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    public $kern;

    /**
     * setUp
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client = static::createClient(array('environment' => $this->environment));
        $this->client->followRedirects();
        $this->kern      = $this->client->getKernel();
        $this->container = $this->client->getContainer();
        $this->em        = $this->container->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();

//        $this->container->get('security.token_storage')->setToken(new UsernamePasswordToken('admin', null, 'secured_area', ['ROLE_ADMINISTRATEUR_SI']));
        //Invalidate latest session
//        $this->container->get('session')->invalidate();
    }

    /**
     * tearDown
     */
    protected function tearDown()
    {
        //Close & unsets
        if (is_object($this->em)) {
            $this->em->rollback();
            $this->em->getConnection()->close();
            $this->em->close();
            unset($this->em);
        }
        unset($this->container);
        unset($this->kern);
        unset($this->client);
        //Nettoyage des mocks
        //http://kriswallsmith.net/post/18029585104/faster-phpunit
        $refl = new \ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
        //Nettoyage du garbage
        if (!gc_enabled()) {
            gc_enable();
        }
        gc_collect_cycles();
        parent::tearDown();
    }

    /**
     * @param mixed $entity
     */
    protected function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     *
     */
    protected function login()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';

        $token = new UsernamePasswordToken($this->em->getRepository('UserBundle:User')->findOneBy(['username' => 'GAIA9']), null, $firewall, array('ROLE_ADMINISTRATEUR_LOCAL'));
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);

    }
}
