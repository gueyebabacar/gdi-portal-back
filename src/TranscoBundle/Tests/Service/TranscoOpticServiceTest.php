<?php

namespace TranscoBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Form\TranscoOpticType;
use TranscoBundle\Repository\TranscoOpticRepository;
use TranscoBundle\Service\TranscoOpticService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TranscoOpticServiceTest
 * @package TranscoBundle\Tests\Service
 */
class TranscoOpticServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  TranscoOpticService
     */
    private $transcoService;

    /**
     * @group transco
     */
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

        $this->transcoService = new TranscoOpticService($em, $formFactory);
    }

    /**
     *
     * @test
     * @group transco
     */
    public function testGetAll()
    {
        $transcos = $this->createTranscoTable();

        $this->emProphecy
            ->getRepository("TranscoBundle:TranscoOptic")
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->findAll()
            ->willReturn($transcos)
            ->shouldBeCalled();

        $this->assertEquals($transcos, $this->transcoService->getAll());
    }

    /**
     *
     * @test
     * @group transco
     */
    public function testCreate()
    {
        $transcoOptic = new TranscoOptic();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(TranscoOpticType::class, $transcoOptic)
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
            ->persist($transcoOptic)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoOptic, $this->transcoService->create($request));
    }

    /**
     *
     * @test
     * @group transco
     */
    public function testGet()
    {
        $transcoOptic = new TranscoOptic();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoOptic'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoOptic)
            ->shouldBeCalled();

        $this->assertEquals($transcoOptic, $this->transcoService->get(1));
    }

    /**
     *
     * @test
     * @group transco
     */
    public function testEdit()
    {
        $transcoOptic = new TranscoOptic();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoOptic'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoOptic)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(TranscoOpticType::class, $transcoOptic)
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
            ->persist($transcoOptic)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoOptic, $this->transcoService->edit($request, 1));
    }

    /**
     *
     * @test
     * @group transco
     */
    public function testDelete()
    {
        $transcoOptic = new TranscoOptic();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoOptic'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoOptic)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($transcoOptic)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->transcoService->delete(1);
    }

    /**
     * @return array
     */
    private function createTranscoTable()
    {
        $transcos = [];

        for ($i = 0; $i < 2; $i++) {

            $transcoOptic = new TranscoOptic();

            $transcoOptic->setCodeTypeOptic(254);
            $transcoOptic->setOpticLabel('lorem ipsum');
            $transcoOptic->setCodeNatInter('lorem ipsum');
            $transcoOptic->setLabelNatInter('lorem ipsum');
            $transcoOptic->setSegmentationCode('055');
            $transcoOptic->setSegmentationLabel('055');
            $transcoOptic->setFinalCode('055');
            $transcoOptic->setFinalLabel('055');
            $transcoOptic->setShortLabel('055');
            $transcoOptic->setProgrammingMode('055');
            $transcoOptic->setCalibre('055');
            $transcoOptic->setSlot('055');
            $transcoOptic->setSla('055');
            $transcoOptic->addGmao(new TranscoGmao());
            $transcoOptic->setDisco('disco');

            $transcos[] = $transcoOptic;
        }
        return $transcos;
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}
