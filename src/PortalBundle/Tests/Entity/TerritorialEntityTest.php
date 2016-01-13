<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\TerritorialEntity;

class TerritorialEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     */
    public function testGettersAndSetters()
    {
        $stub = $this->getMockForAbstractClass(TerritorialEntity::class);

        $data = [
            'code' => 'code',
            'label' => 'label',
        ];

        $stub->setCode($data['code']);
        $stub->setLabel($data['label']);

        $this->assertEquals($data['code'], $stub->getCode());
        $this->assertEquals($data['label'], $stub->getLabel());
    }
}
