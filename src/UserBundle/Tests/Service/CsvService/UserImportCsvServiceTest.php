<?php

namespace UserBundle\Tests\Service;

use Prophecy\Prophet;
use Prophecy\Argument;
use UserBundle\Entity\User;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use Doctrine\ORM\EntityManager;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpKernel\Kernel;
use UserBundle\Service\CsvService\UsersImportCsvService;

class UserImportCsvServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var ObjectProphecy
     */
    private $repositoryProphecy;

    /**
     * @var  UsersImportCsvService
     */
    private $usersImportCsvService;

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

        $this->usersImportCsvService = new UsersImportCsvService($em, $kernel);
    }

    /**
     * @test testGetPath
     */
    public function testGetPath()
    {
        $this->kernelProphecy
            ->getRootDir()
            ->willReturn(string::class)
            ->shouldBeCalled();
        $this->usersImportCsvService->getPath();
    }
    /**
     * @test testImportCsvUsers
     */
    public function testImportCsvUsers()
    {
        $user = new User();
        $agency = new Agency();
        $region = new Region();
        $data = [
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'username' => 'gaia8',
            'email' => 'gueyebaba@gmail.com',
            'entity' => 'APPI',
            'nni' => 'NNI10',
            'phone1' => '123456789',
            'phone2' => '023456789',
            'agency' => $agency,
            'region' => $region,
            'roles' => 'ROLE_TECHNICIEN'
        ];

        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setUsername($data['username']);
        $user->setEntity($data['entity']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->addRole($data['roles']);
        $user->setAgency($data['agency']);
        $user->setRegion($data['region']);

        $this->assertEquals($user->getFirstName(),$data['firstName']);
        $this->assertEquals($user->getLastName(),$data['lastName']);
        $this->assertEquals($user->getUserName(),$data['username']);
        $this->assertEquals($user->getNni(),$data['nni']);
        $this->assertEquals($user->getPhone1(),$data['phone1']);
        $this->assertEquals($user->getPhone2(),$data['phone2']);
        $this->assertEquals($user->getAgency(),$data['agency']);
        $this->assertEquals($user->getRegion(),$data['region']);

        $this->emProphecy
            ->getRepository(Argument::exact('UserBundle:User'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:Region'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:Agency'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->emProphecy
            ->persist($user)
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $data = [
            'path' => '/var/www/app/Resources/csv'
        ];

        $this->usersImportCsvService->importCsvUsers($data['path']);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
