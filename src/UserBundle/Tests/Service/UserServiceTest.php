<?php

namespace UserBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Service\ErrorService;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;
use UserBundle\Form\UserType;
use UserBundle\Repository\UserRepository;
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
     * @var ObjectProphecy
     */
    public $authorizationCheckerProphecy;
    /**
     * @var ObjectProphecy
     */
    public $errorServiceProphecy;

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

        $this->authorizationCheckerProphecy = $this->prophet->prophesize(AuthorizationCheckerInterface::class);
        /** @var AuthorizationChecker $authorizationChecker */
        $authorizationChecker = $this->authorizationCheckerProphecy->reveal();

        $this->errorServiceProphecy = $this->prophet->prophesize(ErrorService::class);
        /** @var AuthorizationChecker $authorizationChecker */
        $errorService = $this->errorServiceProphecy->reveal();

        $this->userService = new UserService($em, $formFactory, $authorizationChecker, $errorService);
    }

    /**
     * @test testGetAll
     */
    public function testGetAll()
    {
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $agency = new Agency();
        $agency->setLabel('agence');
        $agency->setcode('ATG0');
        $agency->setRegion($region);

        $userArray = [
            'id' => 1,
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'username' => 'username',
            'email' => 'email@email.fr',
            'enabled' => true,
            'entity' => 'APPO',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'agency' => $agency,
            'territorialContext' => 'age',
        ];

        $repositoryProphecy = $this->prophet->prophesize(UserRepository::class);

        $this->emProphecy
            ->getRepository("UserBundle:User")
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $repositoryProphecy
            ->getUserAttributes()
            ->willReturn([$userArray])
            ->shouldBeCalled();

        $this->authorizationCheckerProphecy
            ->isGranted('view', $this->formatUser($userArray))
            ->shouldBeCalled();

        $usersResult = $this->userService->getAll();
        $this->assertEquals($userArray['firstName'], $usersResult[0]->getFirstName());
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

        /** @var ObjectProphecy $userTypeProphecy */
        $userTypeProphecy = $this->prophet->prophesize(UserType::class);

        $this->formFactoryProphecy
            ->create(UserType::class, $user->setSalt(null))
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
            ->persist(Argument::exact($user))
            ->shouldBeCalled();

        $this->emProphecy
            ->flush()
            ->shouldBeCalled();
        $this->userService->create($request);
    }

    /**
     * @test testGet
     */
    public function testGet()
    {
        $this->markTestSkipped();
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $agency = new Agency();
        $agency->setLabel('agence');
        $agency->setcode('ATG0');
        $agency->setRegion($region);

        $userArray = [
            'id' => 1,
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'username' => 'username',
            'email' => 'email@email.fr',
            'enabled' => true,
            'entity' => 'APPO',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'agency' => $agency,
            'territorialContext' => 'age',
        ];

        $repositoryProphecy = $this->prophet->prophesize(UserRepository::class);

        $this->emProphecy
            ->getRepository("UserBundle:User")
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->getUserAttributes(1)
            ->willReturn([$userArray])
            ->shouldBeCalled();
        $this->userService->get(1);
    }

    /**
     * @test testEdit
     */
    public function testEdit()
    {
        $this->markTestSkipped();

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
        $this->markTestSkipped();

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
            'username' => 'gaia',
            'email' => 'email@email.fr',
            'entity' => 'APPO',
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

    /**
     * @param $userArray
     * @return User
     */
    private function formatUser($userArray)
    {
        $u = new User;
        $u->setId($userArray['id']);
        $u->setFirstName($userArray['firstName']);
        $u->setLastName($userArray['lastName']);
        $u->setEntity($userArray['entity']);
        $u->setUsername($userArray['username']);
        $u->setRoles($userArray['roles']);
        $u->setEnabled($userArray['enabled']);
        $u->setSalt(null);
        if (isset($userArray['agencyId'])) {
            $u->setAgency($this->em->getRepository('PortalBundle:Agency')->find($userArray['agencyId']));
            return $u;
        } elseif (isset($userArray['regionId'])) {
            $u->setRegion($this->em->getRepository('PortalBundle:Region')->find($userArray['regionId']));
            return $u;
        } else {
            $u->setTerritorialCode("");
            return $u;
        }
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
