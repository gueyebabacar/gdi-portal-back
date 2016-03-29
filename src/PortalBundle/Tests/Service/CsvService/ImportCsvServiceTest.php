<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityRepository;
use PortalBundle\Service\CsvService\ImportCsvService;
use Prophecy\Prophet;
use Prophecy\Argument;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use Doctrine\ORM\EntityManager;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpKernel\Kernel;

class ImportCsvServiceTest extends \PHPUnit_Framework_TestCase
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
    private $kernelProphecy;

    /**
     * @var ImportCsvService
     */
    private $importCsvService;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

        $this->emProphecy = $this->prophet->prophesize(EntityManager::class);
        /** @var EntityManager $em */
        $em = $this->emProphecy->reveal();

        $this->kernelProphecy = $this->prophet->prophesize(Kernel::class);
        /** @var Kernel $kernel */
        $kernel = $this->kernelProphecy->reveal();

        $this->importCsvService = new ImportCsvService($em, $kernel);
    }

    /**
     * @test testGetPath
     */
    public function testGetPath()
    {
        $this->markTestSkipped();
        $this->kernelProphecy
            ->getRootDir()
            ->willReturn("path")
            ->shouldBeCalled();
        $this->importCsvService->getPath();
    }
    /**
     * @test testImportCsvAgences
     */
    public function testImportCsvAgences()
    {
        $this->markTestSkipped();
        $agency = new Agency();
//        $region = new Region();
        $data = [
            'code' => 'REG1',
            'label' => 'Region 1',
            'region' => 1,
        ];

        $repositoryProphecy = $this->prophet->prophesize(EntityRepository::class);

        $agency->setCode($data['code']);
        $agency->setLabel($data['label']);
        $agency->setRegion($data['region']);

        $this->assertEquals($agency->getCode(),$data['code']);
        $this->assertEquals($agency->getLabel(),$data['label']);
        $this->assertEquals($agency->getRegion(),$data['region']);

        $this->emProphecy
            ->getRepository('PortalBundle:Agency')
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $repositoryProphecy
            ->findAll()
            ->willReturn([$agency])
            ->shouldBeCalled();

        $this->emProphecy
            ->persist($agency)
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $data = [
            'path' => '/var/www/app/Resources/csv'
        ];

        $this->importCsvService->importCsvAgences($data['path']);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
