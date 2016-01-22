<?php

namespace TranscoBundle\Tests\Service;

use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityManager;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Kernel;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Service\CsvService\TranscoImportCsvService;

class TranscoImportCsvServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    private $containerProphecy;

    /**
     * @var ObjectProphecy
     */
    private $emProphecy;

    /**
     * @var TranscoImportCsvService
     */
    private $transcoExportCsvService;

    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

        $this->containerProphecy = $this->prophet->prophesize(Container::class);

        $this->emProphecy = $this->prophet->prophesize(EntityManager::class);

        $this->transcoExportCsvService = new TranscoImportCsvService($this->emProphecy->reveal(), $this->containerProphecy->reveal());

    }

    public function testGetPath()
    {
        $this->markTestSkipped();
        $kernelMock = $this->getMockBuilder('Symfony\Component\HttpKernel\Kernel')
            ->disableOriginalConstructor()
            ->getMock();

        $containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expected = "/var/www/gdi-portal-back/web/uploads/csv";

        $containerMock->expects($this->once())
            ->method('get')
            ->willReturn($kernelMock);

        $kernelMock->expects($this->once())
            ->method('getRootDir')
            ->willReturn($expected);


        $this->assertEquals($expected, $this->transcoExportCsvService->getPath());
    }

    public function testExportTranscoDestTerrSiteCvs()
    {
        $this->markTestSkipped();
        $transcoCsvServiceProphecy = $this->prophet->prophesize(TranscoImportCsvService::class);

        $transcoOptic = new TranscoOptic();

        $kernelProphecy = $this->prophet->prophesize(Kernel::class);
        $filePath = 'transco.csv';
        $this->containerProphecy
            ->get("kernel")
            ->willReturn($kernelProphecy)
            ->shouldBeCalled();

        $transcoCsvServiceProphecy
            ->emptyTables()
            ->shouldBeCalled();

        $transcoCsvServiceProphecy
            ->getPath(StringType::class)
            ->willReturn(StringType::class)
            ->shouldBeCalled();

        $this->emProphecy
            ->persist($transcoOptic)
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();


        $this->transcoExportCsvService->importCsvTranscoTables($filePath);
    }

}
