<?php

namespace TranscoBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Form\TranscoGmaoType;
use TranscoBundle\Service\TranscoGmaoService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TranscoGmaoServiceTest
 * @package TranscoBundle\Tests\Service
 */
class TranscoGmaoServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  TranscoGmaoService
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

        $this->transcoService = new TranscoGmaoService($em, $formFactory);
    }

    /**
     * @group transco
     */
    public function testGetAll()
    {
        $transcos = $this->createTranscoTable();

        $this->emProphecy
            ->getRepository("TranscoBundle:TranscoGmao")
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->findAll()
            ->willReturn($transcos)
            ->shouldBeCalled();

        $this->assertEquals($transcos, $this->transcoService->getAll());
    }

    /**
     * @group transco
     */
    public function testCreate()
    {
        $transcoGmao = new TranscoGmao();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(TranscoGmaoType::class, $transcoGmao)
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
            ->persist($transcoGmao)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoGmao, $this->transcoService->create($request));
    }

    /**
     * @group transco
     */
    public function testGet()
    {
        $transcoGmao = new TranscoGmao();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoGmao'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoGmao)
            ->shouldBeCalled();

        $this->assertEquals($transcoGmao, $this->transcoService->get(1));
    }

    /**
     * @group transco
     */
    public function testEdit()
    {
        $transcoGmao = new TranscoGmao();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoGmao'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoGmao)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(TranscoGmaoType::class, $transcoGmao)
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
            ->persist($transcoGmao)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoGmao, $this->transcoService->edit($request, 1));
    }

    /**
     * @group transco
     */
    public function testDelete()
    {
        $transcoGmao = new TranscoGmao();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoGmao'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoGmao)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($transcoGmao)
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

            $transcoGmao = new TranscoGmao();

            $transcoGmao->setWorkType(254);
            $transcoGmao->setGroupGame('lorem ipsum');
            $transcoGmao->setCounter(1);
            $transcoGmao->setOptic('055');

            $transcos[] = $transcoGmao;
        }
        return $transcos;
    }
    
    /**
     * @group transco
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}
