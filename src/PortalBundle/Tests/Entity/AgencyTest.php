<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;

class AgencyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     */
    public function testGettersAndSetters()
    {
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $agency = new Agency();

        $agency->setRegion($region);

        $this->assertEquals($region, $agency->getRegion());
    }
}
