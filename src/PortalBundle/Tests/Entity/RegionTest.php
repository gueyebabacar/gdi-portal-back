<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\Region;
use PortalBundle\Entity\Agency;

class RegionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

    }

    /**
     * @test testGettersAndSetters
     */
    public function testGettersAndSetters()
    {
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $this->assertEquals('region', $region->getLabel());
        $this->assertEquals('REG0', $region->getCode());
    }

    /**
     * @test
     * @group entity
     */
    public function testAdd()
    {
        $label     = 'region0';
        $code      = 'REG0';

        $region = new Region();
        $agency = new Agency();

        $agency
            ->setLabel($label)
            ->setCode($code);

        $this->assertNotNull($region->addAgency($agency));

    }

    /**
     * @test
     * @group entity
     */
    public function testRemov()
    {
        $label     = 'region0';
        $code      = 'REG0';

        $region = new Region();
        $agency = new Agency();

        $agency
            ->setLabel($label)
            ->setCode($code);

        $this->assertNotNull($region->removeAgency($agency));

    }
}