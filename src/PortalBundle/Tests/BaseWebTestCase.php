<?php

namespace PortalBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Process\Process;

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

        //Invalidate latest session
        $this->container->get('session')->invalidate();
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
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass($object);
        $method     = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @param $object
     * @param $propertyName
     * @param $value
     * @return mixed
     */
    public function setPrivateProperty(&$object, $propertyName, $value)
    {
        $reflection = new \ReflectionClass($object);
        $property   = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * @param $object
     * @param $propertyName
     * @return \ReflectionProperty
     */
    public function getPrivateProperty(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $property   = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * Truncate tables
     *
     * @param array $tables
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function truncateTables(array $tables = array())
    {
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=0');

        foreach ($tables as $table) {
            $connection->executeUpdate($dbPlatform->getTruncateTableSQL($table, true));
        }
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Delete tables
     *
     * @param array $tables
     */
    protected function deleteTables(array $tables = array())
    {
        $connection = $this->em->getConnection();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=0');

        foreach ($tables as $table) {
            $connection->executeUpdate('DELETE FROM ' . $table);
        }
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Voids the database
     */
    protected function makeTheVoid()
    {
        $cmd     = "cd " . $this->kern->getRootDir() . " ; php console doctrine:schema:drop -n --force --env=test ; php console doctrine:schema:create --env=test";
        $process = new Process($cmd);
        $process->setTimeout(86400);
        $process->mustRun();
    }

    /**
     * @param mixed $entity
     */
    protected function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
