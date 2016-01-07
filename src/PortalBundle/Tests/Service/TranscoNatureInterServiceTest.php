<?php

namespace PortalBundle\Tests\Service;

use Apoutchika\LoremIpsumBundle\Services\LoremIpsum;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\EntityRepositoryGenerator;
use PhpOption\Tests\Repository;
use PortalBundle\Entity\TranscoNatureInter;
use PortalBundle\Form\TranscoNatureInterType;
use PortalBundle\Repository\TranscoNatureInterRepository;
use PortalBundle\Service\TranscoNatureInterService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class TranscoNatureInterServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  TranscoNatureInterService
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

        $this->transcoService = new TranscoNatureInterService($em, $formFactory);
    }

    public function testGetAll()
    {
        $transcos = $this->createTranscoTable();

        $this->emProphecy
            ->getRepository("PortalBundle:TranscoNatureInter")
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
        $transcoNatureInter = new TranscoNatureInter();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(TranscoNatureInterType::class, $transcoNatureInter)
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
            ->persist($transcoNatureInter)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoNatureInter, $this->transcoService->create($request));
    }

    public function testGet()
    {
        $transcoNatureInter = new TranscoNatureInter();

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:TranscoNatureInter'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoNatureInter)
            ->shouldBeCalled();

        $this->assertEquals($transcoNatureInter, $this->transcoService->get(1));
    }

    public function testEdit()
    {
        $transcoNatureInter = new TranscoNatureInter();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:TranscoNatureInter'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoNatureInter)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(TranscoNatureInterType::class, $transcoNatureInter)
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
            ->persist($transcoNatureInter)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoNatureInter, $this->transcoService->edit($request, 1));
    }

    public function testDelete()
    {
        $transcoNatureInter = new TranscoNatureInter();

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:TranscoNatureInter'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoNatureInter)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($transcoNatureInter)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->transcoService->delete(1);
    }

    public function testGetCodeNatIntFromCodeNatOp(){
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoNatureInterRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:TranscoNatureInter'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findCodeNatIntFromCodeNatOp([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getCodeNatIntFromCodeNatOp([]));
    }

    public function testGetCodeNatOpFromCodeNatInt(){
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoNatureInterRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:TranscoNatureInter'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findCodeNatopFromCodeNatInt([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getCodeNatOpFromCodeNatInt([]));
    }

    private function createTranscoTable()
    {
        $transcos = [];

        for ($i = 0; $i < 2; $i++) {

            $transcoNatureInter = new TranscoNatureInter();

            $transcoNatureInter->setOpticNatCode('AAA');
            $transcoNatureInter->setOpticSkill('lorem ipsum');
            $transcoNatureInter->setOpticNatLabel('lorem ipsum');
            $transcoNatureInter->setPictrelNatOpCode('lorem ipsum');
            $transcoNatureInter->setPictrelNatOpLabel('lorem ipsum');
            $transcoNatureInter->setTroncatedPictrelNatOpLabel('lorem ipsum');
            $transcoNatureInter->setCounter($i);

            $transcos[] = $transcoNatureInter;
        }
        return $transcos;
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
