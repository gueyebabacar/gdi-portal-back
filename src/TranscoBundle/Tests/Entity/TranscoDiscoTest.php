<?php

namespace TranscoBundle\Tests\Entity;

use TranscoBundle\Entity\TranscoDisco;

class TranscoDiscoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group gdi
     * @group entity
     */
    public function testTranscoDiscoSettersGetters()
    {
        $data = array(
            'id' => 1,
            'codeObject' => 'XO7A',
            'natOp' => 'Ck14',
            'natOpLabel' => 'blablablaXX',
            'optic' => 'optic',
        );

        $transcoDisco = new TranscoDisco();

        $transcoDisco->setId($data['id']);
        $transcoDisco->setCodeObject($data['codeObject']);
        $transcoDisco->setNatOp($data['natOp']);
        $transcoDisco->setNatOpLabel($data['natOpLabel']);
        $transcoDisco->setOptic($data['optic']);

        $this->assertEquals($data['id'],  $transcoDisco->getId());
        $this->assertEquals($data['codeObject'], $transcoDisco->getCodeObject());
        $this->assertEquals($data['natOp'], $transcoDisco->getNatOp());
        $this->assertEquals($data['natOpLabel'], $transcoDisco->getNatOpLabel());
        $this->assertEquals($data['optic'], $transcoDisco->getOptic());
    }
}
