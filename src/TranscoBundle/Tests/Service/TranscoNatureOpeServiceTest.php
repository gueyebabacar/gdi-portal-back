<?php

namespace TranscoBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use TranscoBundle\Entity\TranscoNatureOpe;
use TranscoBundle\Form\TranscoNatureOpeType;
use TranscoBundle\Repository\TranscoNatureOpeRepository;
use TranscoBundle\Service\TranscoNatureOpeService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class TranscoNatureOpeServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  TranscoNatureOpeService
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

        $this->transcoService = new TranscoNatureOpeService($em, $formFactory);
    }

    /**
     * testGetAll
     */
    public function testGetAll()
    {
        $transcos = $this->createTranscoTable();

        $this->emProphecy
            ->getRepository("TranscoBundle:TranscoNatureOpe")
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->findAll()
            ->willReturn($transcos)
            ->shouldBeCalled();

        $this->assertEquals($transcos, $this->transcoService->getAll());
    }

    /**
     * testCreate
     */
    public function testCreate()
    {
        $transcoNatureOpe = new TranscoNatureOpe();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(TranscoNatureOpeType::class, $transcoNatureOpe)
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
            ->persist($transcoNatureOpe)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoNatureOpe, $this->transcoService->create($request));
    }

    /**
     * testGet
     */
    public function testGet()
    {
        $transcoNatureOpe = new TranscoNatureOpe();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoNatureOpe'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoNatureOpe)
            ->shouldBeCalled();

        $this->assertEquals($transcoNatureOpe, $this->transcoService->get(1));
    }

    /**
     * testEdit
     */
    public function testEdit()
    {
        $transcoNatureOpe = new TranscoNatureOpe();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoNatureOpe'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoNatureOpe)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(TranscoNatureOpeType::class, $transcoNatureOpe)
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
            ->persist($transcoNatureOpe)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoNatureOpe, $this->transcoService->edit($request, 1));
    }

    /**
     * testEdit
     */
    public function testDelete()
    {
        $transcoNatureOpe = new TranscoNatureOpe();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoNatureOpe'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoNatureOpe)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($transcoNatureOpe)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->transcoService->delete(1);
    }

    /**
     * testGetCodeNatureIntervention3
     */
    public function testGetCodeNatureIntervention3()
    {

        $serviceRepo = $this->prophet->prophesize(TranscoNatureOpeRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoNatureOpe'))
            ->willReturn($serviceRepo)
            ->shouldBeCalled();

        $serviceRepo
            ->findCodeNatureIntervention3([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getCodeNatureIntervention3([]));
    }

    /**
     * testGetModeProgrammation
     */
    public function testGetModeProgrammation()
    {
        $serviceRepo = $this->prophet->prophesize(TranscoNatureOpeRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoNatureOpe'))
            ->willReturn($serviceRepo)
            ->shouldBeCalled();

        $serviceRepo
            ->findModeProgrammation([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getModeProgrammation([]));
    }
    
    private function createTranscoTable()
    {
        $transcos = [];

        for ($i = 0; $i < 2; $i++) {

            $transcoNatureOpe = new TranscoNatureOpe();

            $transcoNatureOpe->setCounter('10');
            $transcoNatureOpe->setGammeGroup('lorem ipsum');
            $transcoNatureOpe->setNatureInterCode('lorem ipsum');
            $transcoNatureOpe->setProgrammingMode('lorem ipsum');
            $transcoNatureOpe->setPurpose('lorem ipsum');
            $transcoNatureOpe->setSegmentationName('lorem ipsum');
            $transcoNatureOpe->setSegmentationValue('lorem ipsum');
            $transcoNatureOpe->setWorkType('lorem ipsum');

            $transcos[] = $transcoNatureOpe;
        }
        return $transcos;
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
