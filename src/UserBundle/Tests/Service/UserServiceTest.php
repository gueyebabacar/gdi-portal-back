<?php

namespace UserBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;
use UserBundle\Form\UserType;
use UserBundle\Service\UserService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class UserServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  UserService
     */
    private $userService;

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

        $this->formFactoryProphecy = $this->prophet->prophesize(FormFactory::class);
        /** @var FormFactory $formFactory */
        $formFactory = $this->formFactoryProphecy->reveal();

        $this->repositoryProphecy = $this->prophet->prophesize(EntityRepository::class);

        $this->userService = new UserService($em, $formFactory);
    }

    /**
     * @test testGetAll
     */
    public function testGetAll()
    {
        $users = $this->createUser();

        $this->emProphecy
            ->getRepository("UserBundle:User")
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->findAll()
            ->willReturn($users)
            ->shouldBeCalled();

        $this->assertEquals($users, $this->userService->getAll());
    }

    /**
     * @test testCreate
     */
    public function testCreate()
    {
        $this->markTestSkipped();
        $user = new User();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);
        $userTypeProphecy = $this->prophet->prophesize(UserType::class);
        $this->formFactoryProphecy
            ->create(Argument::exact(UserType::class), Argument::exact($user))
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
            ->persist($user)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($user, $this->userService->create($request));
    }

    /**
     * @test testGet
     */
    public function testGet()
    {
        $user = new User();

        $this->emProphecy
            ->getRepository(Argument::exact('UserBundle:User'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($user)
            ->shouldBeCalled();

        $this->assertEquals($user, $this->userService->get(1));
    }

    /**
     * @test testEdit
     */
    public function testEdit()
    {
        $user = new User();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('UserBundle:User'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($user)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(UserType::class, $user)
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
            ->persist($user)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($user, $this->userService->edit($request, 1));
    }

    /**
     * @test testDelete
     */
    public function testDelete()
    {
        $user = new User();

        $this->emProphecy
            ->getRepository(Argument::exact('UserBundle:User'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($user)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($user)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->userService->delete(1);
    }

    private function createUser()
    {
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $agency = new Agency();
        $agency->setLabel('agence');
        $agency->setcode('ATG0');
        $agency->setRegion($region);

        $data = [
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'gaia' => 'gaia',
            'email' => 'email',
            'entity' => 'entity',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'agency' => $agency,
            'territorialContext' => 'age',
        ];

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setEntity($data['entity']);
        $user->setUsername($data['gaia']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->setRoles($data['roles']);
        $user->setTerritorialContext($data['territorialContext']);
        $user->setAgency($data['agency']);

        return $user;
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
