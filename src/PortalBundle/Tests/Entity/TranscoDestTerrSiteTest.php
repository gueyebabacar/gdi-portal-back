<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\TranscoDestTerrSite;

class TranscoDestTerrSiteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group pop
     * @group entity
     */
    public function testTranscoDestTerrSiteSettersGetters()
    {
        $data = array(
            'id' => 1,
            'territory' => 254,
            'adressee' => 'COU13',
            'site' => 'DIABLES BLEUS',
            'idRefStructureOp' => 'ATG254',
            'pr' => 'X',
        );

        $transcoDestTerrSite = new TranscoDestTerrSite();

        $transcoDestTerrSite->setId($data['id']);
        $transcoDestTerrSite->setTerritory($data['territory']);
        $transcoDestTerrSite->setAdressee($data['adressee']);
        $transcoDestTerrSite->setIdRefStructureOp($data['idRefStructureOp']);
        $transcoDestTerrSite->setSite($data['site']);
        $transcoDestTerrSite->setPr($data['pr']);

        $this->assertEquals($data['id'], $transcoDestTerrSite->getId());
        $this->assertEquals($data['territory'], $transcoDestTerrSite->getTerritory());
        $this->assertEquals($data['adressee'], $transcoDestTerrSite->getAdressee());
        $this->assertEquals($data['idRefStructureOp'], $transcoDestTerrSite->getIdRefStructureOp());
        $this->assertEquals($data['site'], $transcoDestTerrSite->getSite());
        $this->assertEquals($data['pr'], $transcoDestTerrSite->getPr());
    }
}
