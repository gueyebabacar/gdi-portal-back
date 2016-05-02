<?php

namespace PortalBundle\Tests\Service\CsvService;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Configuration;
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
use UserBundle\Entity\User;
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

    /**
     * setUp
     */
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

        $this->filePath = $this->kern->getRootDir() . '/../web/uploads/csvForTest/';
    }

    /**
     * @test
     * @group importService
     */
    public function testCsvToArraySuccess()
    {
        $fileName = $this->filePath . 'regions.csv';

        $header = ['CodeRegion', 'LibelleRegion'];

        $actual = $this->importService->csvToArray($fileName, $header);
        $this->assertEquals("5", $actual[0]['CodeRegion']);
        $this->assertEquals("MED", $actual[0]['LibelleRegion']);
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
    public function testImportCsvRegionsSuccess()
    {
        $fileName = $this->filePath . 'regions.csv';

        $this->mockImport();

        $this->importService->importCsvRegions($fileName);
    }

    /**
     * @test
     * @group importService
     */
    public function testImportCsvAgenciesSuccess()
    {
        $fileName = $this->filePath . 'agences.csv';

        $this->mockImport();
        $this->agencyRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(new Agency())
            ->shouldBeCalled();

        $this->importService->importCsvAgencies($fileName);
    }

    /**
     * @test
     * @group importService
     */
    public function testImportCsvUsersSuccess()
    {
        $fileName = $this->filePath . 'utilisateurs.csv';

        $this->mockImport();

        $this->agencyRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(new Agency())
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(null)
            ->shouldBeCalledTimes(3);

        $this->importService->importCsvUsers($fileName);
    }

    /**
     * @test
     * @group importService
     */
    public function testImportCsvUsersFailGaia()
    {
        $fileName = $this->filePath . 'utilisateurs.csv';

        $this->mockImport();
        $this->agencyRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(new Agency())
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(new User())
            ->shouldBeCalledTimes(3);

        $this->loggerProphecy
            ->error(Argument::any())
            ->shouldBeCalled();

        $this->importService->importCsvUsers($fileName);
    }

    /**
     * @test
     * @group importService
     */
    public function testImportCsvUsersFailEmail()
    {
        $fileName = $this->filePath . 'utilisateurs.csv';
        $user1 = new User();
        $user2 = new User();
        $user3 = new User();
        $user1->setUsername('1');
        $user1->setEmail('email');
        $user2->setUsername('2');
        $user2->setEmail('email');
        $user3->setUsername('3');
        $user3->setEmail('email');
        $this->mockImport();

        $this->agencyRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(new Agency())
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn($user1)
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn($user2)
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn($user3)
            ->shouldBeCalled();

        $this->loggerProphecy
            ->error(Argument::any())
            ->shouldBeCalled();

        $this->importService->importCsvUsers($fileName);
    }

    /**
     * @test
     * @group importService
     * @group coucou
     */
    public function testImportCsvUsersFailNNI()
    {
        $fileName = $this->filePath . 'utilisateurs.csv';

        $user1 = new User();
        $user2 = new User();
        $user3 = new User();

        $user1->setUsername('1');
        $user1->setNni('nni');
        $user1->setEmail('1');

        $user2->setUsername('2');
        $user2->setNni('nni');
        $user2->setEmail('2');

        $user3->setUsername('3');
        $user3->setNni('nni');
        $user3->setEmail('3');

        $this->mockImport();

        $this->agencyRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(new Agency())
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneByUsername(Argument::type('array'))
            ->willReturn(null)
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneByEmail(Argument::type('array'))
            ->willReturn(null)
            ->shouldBeCalled();

        $this->userRepoProphecy
            ->findOneByNni(Argument::type('array'))
            ->willReturn(new User)
            ->shouldBeCalled();

//        $this->loggerProphecy
//            ->error(Argument::any())
//            ->shouldBeCalled();

        $this->importService->importCsvUsers($fileName);
    }

    /**
     * mockImport
     */
    private function mockImport()
    {
        $connnectionProphecy = $this->prophet->prophesize(Connection::class);
        $configurationProphecy = $this->prophet->prophesize(Configuration::class);

        $this->emProphecy
            ->getConnection()
            ->willReturn($connnectionProphecy->reveal())
            ->shouldBeCalled();

        $connnectionProphecy
            ->getConfiguration()
            ->willReturn($configurationProphecy->reveal())
            ->shouldBeCalled();

        $configurationProphecy
            ->setSQLLogger(null)
            ->shouldBeCalled();

        $connnectionProphecy
            ->beginTransaction()
            ->shouldBeCalled();

        $this->loggerProphecy
            ->info(Argument::any())
            ->shouldBeCalled();

        $this->regionRepoProphecy
            ->findOneBy(Argument::type('array'))
            ->willReturn(new Region())
            ->shouldBeCalled();

        $this->emProphecy
            ->persist(Argument::any())
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $connnectionProphecy
            ->commit()
            ->shouldBeCalled();

        $this->emProphecy
            ->clear()
            ->shouldBeCalled();

        $this->loggerProphecy
            ->info(Argument::any())
            ->shouldBeCalled();
    }

    /**
     * tearDown
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}
