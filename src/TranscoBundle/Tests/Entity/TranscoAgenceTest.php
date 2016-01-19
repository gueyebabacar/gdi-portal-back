<?php

namespace TranscoBundle\Tests\Entity;

use TranscoBundle\Entity\TranscoAgence;

class TranscoAgenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group gdi
     * @group entity
     */
    public function testTranscoAgenceSettersGetters()
    {
        $data = array(
            'id' => 1,
            'inseeCode' => 'XO7A',
            'codeAgence' => 'Ck14',
            'agenceLabel' => 'CONDORCET',
            'center' => 'ATG254',
            'destinataire' => 'NEUILLY',
            'pr' => 'X',
        );

        $transcoAgence = new TranscoAgence();

        $transcoAgence->setId($data['id']);
        $transcoAgence->setInseeCode($data['inseeCode']);
        $transcoAgence->setCodeAgence($data['codeAgence']);
        $transcoAgence->setAgenceLabel($data['agenceLabel']);
        $transcoAgence->setCenter($data['center']);
        $transcoAgence->setDestinataire($data['destinataire']);
        $transcoAgence->setPr($data['pr']);

        $this->assertEquals($data['id'], $transcoAgence->getId());
        $this->assertEquals($data['inseeCode'], $transcoAgence->getInseeCode());
        $this->assertEquals($data['codeAgence'], $transcoAgence->getCodeAgence());
        $this->assertEquals($data['agenceLabel'], $transcoAgence->getAgenceLabel());
        $this->assertEquals($data['center'], $transcoAgence->getCenter());
        $this->assertEquals($data['destinataire'], $transcoAgence->getDestinataire());
        $this->assertEquals($data['pr'], $transcoAgence->getPr());
    }
}
