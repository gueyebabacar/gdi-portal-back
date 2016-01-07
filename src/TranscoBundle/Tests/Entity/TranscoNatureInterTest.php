<?php

namespace TranscoBundle\Tests\Entity;

use TranscoBundle\Entity\TranscoNatureInter;

class TranscoNatureInterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group pop
     * @group entity
     */
    public function testTranscoNatureInterSettersGetters()
    {
        $data = array(
            'id' => 1,
            'opticNatCode' => 'ROBI',
            'opticSkill' => 'Maintenance Robinet',
            'opticNatLabel' => 'Inspection robinet reseau',
            'pictrelNatOpCode' => 'AA',
            'pictrelNatLabel' => 'Inspection robinet reseau',
            'troncatedPictrelNatOpLabel' => 'Inspection robinet reseau',
            'app' => 1,
        );

        $transcoNatureInter = new TranscoNatureInter();

        $transcoNatureInter->setId($data['id']);
        $transcoNatureInter->setOpticNatCode($data['opticNatCode']);
        $transcoNatureInter->setOpticSkill($data['opticSkill']);
        $transcoNatureInter->setOpticNatLabel($data['opticNatLabel']);
        $transcoNatureInter->setPictrelNatOpCode($data['pictrelNatOpCode']);
        $transcoNatureInter->setPictrelNatOpLabel($data['pictrelNatLabel']);
        $transcoNatureInter->setTroncatedPictrelNatOpLabel($data['troncatedPictrelNatOpLabel']);
        $transcoNatureInter->setCounter($data['app']);

        $this->assertEquals($data['id'], $transcoNatureInter->getId());
        $this->assertEquals($data['opticNatCode'], $transcoNatureInter->getOpticNatCode());
        $this->assertEquals($data['opticNatLabel'], $transcoNatureInter->getOpticNatLabel());
        $this->assertEquals($data['pictrelNatOpCode'], $transcoNatureInter->getPictrelNatOpCode());
        $this->assertEquals($data['pictrelNatLabel'], $transcoNatureInter->getPictrelNatOpLabel());
        $this->assertEquals($data['troncatedPictrelNatOpLabel'], $transcoNatureInter->getTroncatedPictrelNatOpLabel());
        $this->assertEquals($data['app'], $transcoNatureInter->getCounter());
    }
}
