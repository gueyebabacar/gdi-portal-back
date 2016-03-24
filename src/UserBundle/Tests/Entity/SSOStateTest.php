<?php

namespace UserBundle\Tests\Entity;

use PortalBundle\Entity\Agency;
use UserBundle\Entity\SSOState;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;

class SSOStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     * @group entity
     */
    public function testGetId()
    {
        $sso = new SSOState();
        $sso->setId(1);
        $this->assertEquals(1, $sso->getId());
    }
}
