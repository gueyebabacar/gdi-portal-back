<?php

namespace TranscoBundle\Tests\Repository;

use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Repository\TranscoDestTerrSiteRepository;
use TranscoBundle\Service\SoapService\ExposedWSService;
use TranscoBundle\Tests\BaseWebTestCase;

class TranscoDestTerrSiteRepositoryTest extends BaseWebTestCase
{
    /**
     * @var TranscoDestTerrSiteRepository
     */
    private $transcoDestTerrSiteRepo;

    public function setUp()
    {
        parent::setUp();
        $this->transcoDestTerrSiteRepo = $this->em->getRepository('TranscoBundle:TranscoDestTerrSite');
    }

    /**
     * testFindTerritoryFromAtg
     */
    public function testFindTerritoryFromAtg()
    {
        $data['criteria'][0]['value'] = 59;
        $this->insertTranscoDestTerrSite();
        $result = $this->transcoDestTerrSiteRepo->findTerritoryFromAtg($data);
        $this->assertEquals(reset($result[0]), "056");
    }

    /**
     * testFindAdresseeFromAtg
     */
    public function testFindAdresseeFromAtg()
    {
        $data['criteria'][0]['value'] = 59;
        $this->insertTranscoDestTerrSite();
        $result = $this->transcoDestTerrSiteRepo->findAdresseeFromAtg($data);
        $this->assertEquals(reset($result[0]), "adresse");
    }

    /**
     * testFindPrFromAtg
     */
    public function testFindPrFromAtg()
    {
        $data['criteria'][0]['value'] = 59;
        $this->insertTranscoDestTerrSite();
        $result = $this->transcoDestTerrSiteRepo->findPrFromAtg($data);
        $this->assertEquals(reset($result[0]), "PR");
    }

    /**
     * testTindAtgFromTerritoryOrAdressee
     */
    public function testFindAtgFromTerritoryOrAdressee()
    {
        $data['criteria'][0]['value'] = '056';
        $data['criteria'][0]['name'] = ExposedWSService::ATG;
        $this->insertTranscoDestTerrSite();
        $result = $this->transcoDestTerrSiteRepo->findAtgFromTerritoryOrAdressee($data);
        $this->assertEquals(reset($result[0]), 59);

        $data['criteria'][0]['value'] = 'adresse';
        $data['criteria'][0]['name'] = ExposedWSService::ADRESSEE;
        $this->insertTranscoDestTerrSite();
        $result = $this->transcoDestTerrSiteRepo->findAtgFromTerritoryOrAdressee($data);
        $this->assertEquals(reset($result[0]), 59);
    }

    /**
     *insertTranscoDestTerrSite
     */
    private function insertTranscoDestTerrSite()
    {
        $transcoDestTerrSite = new TranscoDestTerrSite();

        $transcoDestTerrSite->setIdRefStructureOp(59);
        $transcoDestTerrSite->setAdressee('adresse');
        $transcoDestTerrSite->setSite('site');
        $transcoDestTerrSite->setPr('PR');
        $transcoDestTerrSite->setTerritory('056');

        $this->em->persist($transcoDestTerrSite);
        $this->em->flush();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}