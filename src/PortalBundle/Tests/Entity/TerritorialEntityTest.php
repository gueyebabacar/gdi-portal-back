<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\TerritorialEntity;

class TerritorialEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     * @group entity
     */
    public function testGettersAndSetters()
    {
        /** @var TerritorialEntity $stub */
        $stub = $this->getMockForAbstractClass(TerritorialEntity::class);

        $data = [
            'id' => 1,
            'code' => 'code',
            'label' => 'label',
        ];

        $stub->setCode($data['code']);
        $stub->setLabel($data['label']);
        $stub->setId($data['id']);

        $this->assertEquals($data['code'], $stub->getCode());
        $this->assertEquals($data['label'], $stub->getLabel());
        $this->assertEquals($data['id'], $stub->getId());
    }
}
