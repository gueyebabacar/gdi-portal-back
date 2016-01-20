<?php

namespace TranscoBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Form\TranscoAgenceType;
use TranscoBundle\Repository\TranscoAgenceRepository;
use TranscoBundle\Service\TranscoAgenceService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TranscoAgenceServiceTest
 * @package TranscoBundle\Tests\Service
 */
class TranscoAgenceServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  TranscoAgenceService
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

        $this->transcoService = new TranscoAgenceService($em, $formFactory);
    }

    /**
     * @group transco
     */
    public function testGetAll()
    {
        $transcos = $this->createTranscoTable();

        $this->emProphecy
            ->getRepository("TranscoBundle:TranscoAgence")
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
        $transcoAgence = new TranscoAgence();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(TranscoAgenceType::class, $transcoAgence)
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
            ->persist($transcoAgence)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoAgence, $this->transcoService->create($request));
    }

    /**
     * @group transco
     */
    public function testGet()
    {
        $transcoAgence = new TranscoAgence();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoAgence'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoAgence)
            ->shouldBeCalled();

        $this->assertEquals($transcoAgence, $this->transcoService->get(1));
    }

    /**
     * @group transco
     */
    public function testEdit()
    {
        $transcoAgence = new TranscoAgence();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoAgence'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoAgence)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(TranscoAgenceType::class, $transcoAgence)
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
            ->persist($transcoAgence)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($transcoAgence, $this->transcoService->edit($request, 1));
    }

    /**
     * @group transco
     */
    public function testDelete()
    {
        $transcoAgence = new TranscoAgence();

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoAgence'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($transcoAgence)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($transcoAgence)
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

            $transcoAgence = new TranscoAgence();

            $transcoAgence->setInseeCode(254);
            $transcoAgence->setCodeAgence('lorem ipsum');
            $transcoAgence->setAgenceLabel('lorem ipsum');
            $transcoAgence->setCenter('lorem ipsum');
            $transcoAgence->setDestinataire('055');
            $transcoAgence->setPr('055');

            $transcos[] = $transcoAgence;
        }
        return $transcos;
    }

    /**
     * @group transco
     */
    public function testGetEnvoiDIRG()
    {
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoAgenceRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoAgence'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findEnvoiDirgAgenceRequest([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getEnvoiDIRG([]));
    }

     /**
     * @group transco
     */
    public function testGetPublicationOt()
    {
        $transcoRepositoryProphecy = $this->prophet->prophesize(TranscoAgenceRepository::class);

        $this->emProphecy
            ->getRepository(Argument::exact('TranscoBundle:TranscoAgence'))
            ->willReturn($transcoRepositoryProphecy->reveal())
            ->shouldBeCalled();

        $transcoRepositoryProphecy
            ->findPublicationOtRequest([])
            ->willReturn([])
            ->shouldBeCalled();

        $this->assertEquals([], $this->transcoService->getPublicationOt([]));
    }

    /**
     * @group transco
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}
