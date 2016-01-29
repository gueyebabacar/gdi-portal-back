<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;

class RegionTest extends \PHPUnit_Framework_TestCase
{
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
}
