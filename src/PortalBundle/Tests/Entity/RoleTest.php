<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\Role;

class RoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group portal
     * @group entity
     */
    public function testRoleSettersGetters()
    {
        $data = array(
            'id' => 1,
            'label' => 'technicien',
            'code' => 'XX05',

        );

        $role = new Role();

        $role->setId($data['id']);
        $role->setLabel($data['label']);
        $role->setCode($data['code']);

        $this->assertEquals($data['id'], $role->getId());
        $this->assertEquals($data['label'], $role->getLabel());
        $this->assertEquals($data['code'], $role->getCode());

    }
}
