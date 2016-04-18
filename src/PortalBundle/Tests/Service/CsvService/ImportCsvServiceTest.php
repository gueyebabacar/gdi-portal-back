<?php

namespace PortalBundle\Tests\Service\CsvService;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use PortalBundle\Controller\AgencyController;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Repository\AgencyRepository;
use PortalBundle\Repository\RegionRepository;
use PortalBundle\Service\CsvService\ImportCsvService;
use PortalBundle\Tests\BaseWebTestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\HttpKernel\Kernel;
use UserBundle\Repository\UserRepository;

/**
 * Class ImportServiceTest
 * @package PortalBundle\Tests\Service\CsvService
 */
class ImportServiceTest extends BaseWebTestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    protected $emProphecy;

    /**
     * @var ObjectProphecy
     */
    protected $kernelProphecy;

    /**
     * @var ObjectProphecy
     */
    protected $regionRepoProphecy;

    /**
     * @var ObjectProphecy
     */
    protected $agencyRepoProphecy;

    /**
     * @var ObjectProphecy
     */
    protected $userRepoProphecy;

    /**
     * @var ObjectProphecy
     */
    protected $loggerProphecy;

    /**
     * @var ImportCsvService
     */
    protected $importService;

    /**
     * @var string
     */
    protected $filePath;

    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();
        $this->emProphecy = $this->prophet->prophesize(EntityManager::class);
        $this->regionRepoProphecy = $this->prophet->prophesize(RegionRepository::class);
        $this->agencyRepoProphecy = $this->prophet->prophesize(AgencyRepository::class);
        $this->userRepoProphecy = $this->prophet->prophesize(UserRepository::class);
        $this->kernelProphecy = $this->prophet->prophesize(Kernel::class);
        $this->loggerProphecy = $this->prophet->prophesize(Logger::class);

        $em = $this->emProphecy->reveal();
        $this->importService = new ImportCsvService(
            $this->regionRepoProphecy->reveal(),
            $this->agencyRepoProphecy->reveal(),
            $this->userRepoProphecy->reveal(),
            $em,
            $this->kernelProphecy->reveal(),
            $this->loggerProphecy->reveal()
        );

        $this->filePath = $this->kern->getRootDir() . '/../web/uploads/csv/';
    }

    /**
     * @test
     * @group importService
     */
    public function testCsvToArraySuccess()
    {
        $fileName = $this->filePath . 'PortailRegion.csv';

        $header = ['CodeRegion', 'LibelleRegion'];

        $actual = $this->importService->csvToArray($fileName, $header);
        $this->assertEquals("7", $actual[0]['CodeRegion']);
        $this->assertEquals("OUEST", $actual[0]['LibelleRegion']);
    }

    /**
     * @test
     * @group importService
     */
    public function testCsvToArrayFail()
    {
        $fileName = $this->filePath . 'nofile.csv';

        $header = ['CodeRegion', 'LibelleRegion'];

        $actual = $this->importService->csvToArray($fileName, $header);

        $this->assertFalse($actual);
    }

    /**
     * @test
     * @group importService
     */
    public function testImportCsvRegions()
    {
        $this->markTestSkipped();
        $fileName = $this->filePath . 'PERF_Region.v3.csv';

        $this->emProphecy
            ->persist(Argument::any())
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->importService->importCsvRegions($fileName);
    }

    /**
     * @test
     * @group importService
     */
    public function testImportCsvAgencies()
    {
        $this->markTestSkipped();

        $fileName = $this->filePath . 'PERF_Agence.v3.csv';

        $this->regionRepoProphecy
            ->findOneBy(Argument::any())
            ->willReturn(new Region())
            ->shouldBeCalled();

        $this->agencyRepoProphecy
            ->findOneBy(Argument::any())
            ->willReturn(null)
            ->shouldBeCalled();

        $this->emProphecy
            ->persist(Argument::any())
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->importService->importCsvAgencies($fileName);
    }

    public function testImportCsvUsers()
    {
        $this->markTestSkipped();

        $fileName = $this->filePath . 'utilisateurs.csv';

        $this->regionRepoProphecy
            ->findOneBy(Argument::any())
            ->willReturn(new Region())
            ->shouldBeCalled();

        $this->agencyRepoProphecy
            ->findOneBy(Argument::any())
            ->willReturn(new Agency())
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneBy(Argument::any())
            ->willReturn(null)
            ->shouldBeCalled();

        $this->emProphecy
            ->persist(Argument::any())
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->importService->importCsvUsers($fileName);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
