<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\Region;
use PortalBundle\Entity\Agency;

class RegionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * setUp
     * @group entity
     */
    public function setUp()
    {
        parent::setUp();

    }

    /**
     * @test testGettersAndSetters
     * @group entity
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

        $region->addAgency($agency);
        $this->assertTrue($region->getAgencies()->contains($agency));
    }

    /**
     * @test
     * @group entity
     */
    public function testRemove()
    {
        $label     = 'region0';
        $code      = 'REG0';

        $region = new Region();
        $agency = new Agency();

        $agency
            ->setLabel($label)
            ->setCode($code);
        $region->addAgency($agency);
        $this->assertTrue($region->getAgencies()->contains($agency));
        $region->removeAgency($agency);
        $this->assertFalse($region->getAgencies()->contains($agency));
    }
}