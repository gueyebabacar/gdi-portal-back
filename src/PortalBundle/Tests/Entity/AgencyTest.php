<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;

class AgencyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     * @group entity
     */
    public function testGettersAndSetters()
    {
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $agency = new Agency();

        $agency->setRegion($region);
        $agency->setLabel('agency');
        $agency->setCode('AGE0');

        $this->assertEquals($region, $agency->getRegion());
        $this->assertEquals('agency', $agency->getLabel());
        $this->assertEquals('AGE0', $agency->getCode());
    }
}
