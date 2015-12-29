<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\TranscoNatureOpe;

class TranscoNatureOpeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group portal
     * @group entity
     */
    public function testTranscoNatureInterSettersGetters()
    {
        $data = array(
            'id' => 1,
            'workType' => 'ROBI',
            'gammeGroup' => 'Maintenance Robinet',
            'purpose' => 'Inspection robinet reseau',
            'Counter' => 'AA',
            'segmentationValue' => 'Inspection robinet reseau',
            'segmentationName' => 'Inspection robinet reseau',
            'programmingMode' => 'Inspection robinet reseau',
            'natureInterCode' => 'Inspection robinet reseau',
        );

        $transcoNatureOpe = new TranscoNatureOpe();

        $transcoNatureOpe->setId($data['id']);
        $transcoNatureOpe->setWorkType($data['workType']);
        $transcoNatureOpe->setGammeGroup($data['gammeGroup']);
        $transcoNatureOpe->setPurpose($data['purpose']);
        $transcoNatureOpe->setCounter($data['Counter']);
        $transcoNatureOpe->setSegmentationValue($data['segmentationValue']);
        $transcoNatureOpe->setSegmentationName($data['segmentationName']);
        $transcoNatureOpe->setProgrammingMode($data['programmingMode']);
        $transcoNatureOpe->setNatureInterCode($data['natureInterCode']);

        $this->assertEquals($data['id'], $transcoNatureOpe->getId());
        $this->assertEquals($data['workType'], $transcoNatureOpe->getWorkType());
        $this->assertEquals($data['gammeGroup'], $transcoNatureOpe->getGammeGroup());
        $this->assertEquals($data['purpose'], $transcoNatureOpe->getPurpose());
        $this->assertEquals($data['Counter'], $transcoNatureOpe->getCounter());
        $this->assertEquals($data['segmentationValue'], $transcoNatureOpe->getSegmentationValue());
        $this->assertEquals($data['segmentationName'], $transcoNatureOpe->getSegmentationName());
        $this->assertEquals($data['programmingMode'], $transcoNatureOpe->getProgrammingMode());
        $this->assertEquals($data['natureInterCode'], $transcoNatureOpe->getNatureInterCode());
    }
}

