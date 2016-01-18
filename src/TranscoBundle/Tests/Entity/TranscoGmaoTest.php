<?php

namespace TranscoBundle\Tests\Entity;

use TranscoBundle\Entity\TranscoGmao;

class TranscoGmaoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group gdi
     * @group entity
     */
    public function testTranscoGmaoSettersGetters()
    {
        $data = array(
            'id' => 1,
            'workType' => 'worktype',
            'groupGame' => 'groupe de gamme',
            'counter' => 10,
            'optic' => 'optic',
        );

        $transcoGmao = new TranscoGmao();

        $transcoGmao->setId($data['id']);
        $transcoGmao->setWorkType($data['workType']);
        $transcoGmao->setGroupGame($data['groupGame']);
        $transcoGmao->setCounter($data['counter']);
        $transcoGmao->setOptic($data['optic']);

        $this->assertEquals($data['id'],  $transcoGmao->getId());
        $this->assertEquals($data['workType'], $transcoGmao->getWorkType());
        $this->assertEquals($data['groupGame'], $transcoGmao->getGroupGame());
        $this->assertEquals($data['counter'], $transcoGmao->getCounter());
        $this->assertEquals($data['optic'], $transcoGmao->getOptic());
    }
}
