<?php

namespace TranscoBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Form\TranscoDiscoType;
use TranscoBundle\Repository\TranscoDiscoRepository;
use TranscoBundle\Service\TranscoDiscoService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TranscoDiscoServiceTest
 * @package TranscoBundle\Tests\Service
 */
class TranscoDiscoServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  TranscoDiscoService
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

        $this->transcoService = new TranscoDiscoService($em, $formFactory);
    }

    /**
     * @group transco
     */
    public function testGetAll()
    {
        $transcos = $this->createTranscoTable();

        $this->emProphecy
            ->getRepository("TranscoBundle:TranscoDisco")
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
        $transcoDisco = new TranscoDisco();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(TranscoDiscoType::class, $transcoDisco)
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
            ->persist($transcoDisco)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoDisco, $this->transcoService->create($request));
    }

    /**
     * @group transco
     */
    public function testGet()
    {
        $transcoDisco = new TranscoDisco();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDisco'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoDisco)
            ->shouldBeCalled();

        $this->assertEquals($transcoDisco, $this->transcoService->get(1));
    }

    /**
     * @group transco
     */
    public function testEdit()
    {
        $transcoDisco = new TranscoDisco();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDisco'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoDisco)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(TranscoDiscoType::class, $transcoDisco)
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
            ->persist($transcoDisco)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoDisco, $this->transcoService->edit($request, 1));
    }

    /**
     * @group transco
     */
    public function testDelete()
    {
        $transcoDisco = new TranscoDisco();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDisco'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoDisco)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($transcoDisco)
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

            $transcoDisco = new TranscoDisco();

            $transcoDisco->setCodeObject(254);
            $transcoDisco->setNatOp('lorem ipsum');
            $transcoDisco->setNatOpLabel('lorem ipsum');
            $transcoDisco->setOptic('055');
            
            $transcos[] = $transcoDisco;
        }
        return $transcos;
    }

    /**
     * @group transco
     */
    public function testGetEnvoiDIRG()
    {
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoDiscoRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoDisco'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findEnvoiDirgDiscoRequest([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getEnvoiDIRG([]));
    }

    /**
     * @group transco
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}
