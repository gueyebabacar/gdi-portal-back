<?php

namespace TranscoBundle\Tests\Service;

use Apoutchika\LoremIpsumBundle\Services\LoremIpsum;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\EntityRepositoryGenerator;
use PhpOption\Tests\Repository;
use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Form\TranscoDestTerrSiteType;
use TranscoBundle\Form\TranscoDestTerrSiteTypeType;
use TranscoBundle\Repository\TranscoDestTerrSiteRepository;
use TranscoBundle\Service\TranscoDestTerrSiteService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class TranscoDestTerrSiteServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    private $emProphecy;

    /**
     * @var ObjectProphecy
     */
    private $formFactoryProphecy;

    /**
     * @var ObjectProphecy
     */
    private $repositoryProphecy;

    /**
     * @var  TranscoDestTerrSiteService
     */
    private $transcoService;

    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

        $this->emProphecy = $this->prophet->prophesize(EntityManager::class);
        /** @var EntityManager $em */
        $em = $this->emProphecy->reveal();

        $this->formFactoryProphecy = $this->prophet->prophesize(FormFactory::class);
        /** @var FormFactory $formFactory */
        $formFactory = $this->formFactoryProphecy->reveal();

        $this->repositoryProphecy = $this->prophet->prophesize(EntityRepository::class);

        $this->transcoService = new TranscoDestTerrSiteService($em, $formFactory);
    }

    public function testGetAll()
    {
        $transcos = $this->createTranscoTable();

        $this->emProphecy
            ->getRepository("TranscoBundle:TranscoDestTerrSite")
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->findAll()
            ->willReturn($transcos)
            ->shouldBeCalled();

        $this->assertEquals($transcos, $this->transcoService->getAll());
    }

    public function testCreate()
    {
        $transcoDestTerrSite = new TranscoDestTerrSite();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(TranscoDestTerrSiteType::class, $transcoDestTerrSite)
            ->willReturn($formProphecy->reveal())
            ->shouldBeCalled();

        $formProphecy
            ->handleRequest($requestProphecy->reveal())
            ->shouldBeCalled();
        $formProphecy
            ->isSubmitted()
            ->willReturn(true)
            ->shouldBeCalled();
        $formProphecy
            ->isValid()
            ->willReturn(true)
            ->shouldBeCalled();

        $this->emProphecy
            ->persist($transcoDestTerrSite)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoDestTerrSite, $this->transcoService->create($request));
    }

    public function testGet()
    {
        $transcoDestTerrSite = new TranscoDestTerrSite();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDestTerrSite'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoDestTerrSite)
            ->shouldBeCalled();

        $this->assertEquals($transcoDestTerrSite, $this->transcoService->get(1));
    }

    public function testEdit()
    {
        $transcoDestTerrSite = new TranscoDestTerrSite();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDestTerrSite'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoDestTerrSite)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(TranscoDestTerrSiteType::class, $transcoDestTerrSite)
            ->willReturn($formProphecy->reveal())
            ->shouldBeCalled();

        $formProphecy
            ->handleRequest($requestProphecy->reveal())
            ->shouldBeCalled();
        $formProphecy
            ->isSubmitted()
            ->willReturn(true)
            ->shouldBeCalled();
        $formProphecy
            ->isValid()
            ->willReturn(true)
            ->shouldBeCalled();

        $this->emProphecy
            ->persist($transcoDestTerrSite)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoDestTerrSite, $this->transcoService->edit($request, 1));
    }

    public function testDelete()
    {
        $transcoDestTerrSite = new TranscoDestTerrSite();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDestTerrSite'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoDestTerrSite)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($transcoDestTerrSite)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->transcoService->delete(1);
    }

    private function createTranscoTable()
    {
        $transcos = [];

        for ($i = 0; $i < 2; $i++) {

            $transcoDestTerrSite = new TranscoDestTerrSite();

            $transcoDestTerrSite->setIdRefStructureOp(254);
            $transcoDestTerrSite->setAdressee('lorem ipsum');
            $transcoDestTerrSite->setSite('lorem ipsum');
            $transcoDestTerrSite->setPr('lorem ipsum');
            $transcoDestTerrSite->setTerritory('055');

            $transcos[] = $transcoDestTerrSite;
        }
        return $transcos;
    }

    public function testGetTerritoryFromAtg(){
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoDestTerrSiteRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDestTerrSite'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findTerritoryFromAtg([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getTerritoryFromAtg([]));
    }

    public function testGetAtgFromTerritoryOrAdressee(){
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoDestTerrSiteRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDestTerrSite'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findAtgFromTerritoryOrAdressee([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getAtgFromTerritoryOrAdressee([]));
    }

    public function testGetAdresseeFromAtg(){
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoDestTerrSiteRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDestTerrSite'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findAdresseeFromAtg([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getAdresseeFromAtg([]));
    }

    public function testgetPrFromAtg(){
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoDestTerrSiteRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDestTerrSite'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findPrFromAtg([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getPrFromAtg([]));
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
