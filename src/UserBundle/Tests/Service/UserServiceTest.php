<?php

namespace UserBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Repository\AgencyRepository;
use PortalBundle\Repository\RegionRepository;
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

        $usersSent = [];

        $userArray = [
            'id' => 1,
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'username' => 'username',
            'email' => 'email@email.fr',
            'enabled' => true,
            'entity' => 'APPI',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'agency' => ['id' => 1],
            'region' => ['id' => 1],
            'territorialContext' => 'age',
        ];

        $userObject = $this->formatUser($userArray);

        $repositoryProphecy = $this->prophet->prophesize(UserRepository::class);
        $regionRepositoryProphecy = $this->prophet->prophesize(RegionRepository::class);
        $agencyRepositoryProphecy = $this->prophet->prophesize(AgencyRepository::class);
        $userServiceProphecy = $this->prophet->prophesize(UserService::class);

        $this->emProphecy
            ->getRepository("UserBundle:User")
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $repositoryProphecy
            ->getUserAttributes()
            ->willReturn([$userArray])
            ->shouldBeCalled();


        foreach ([$userArray] as $user) {
            $this->emProphecy
                ->getRepository("PortalBundle:Region")
                ->willReturn($regionRepositoryProphecy)
                ->shouldBeCalled();

            $this->emProphecy
                ->getRepository("PortalBundle:Agency")
                ->willReturn($agencyRepositoryProphecy)
                ->shouldBeCalled();

            $userServiceProphecy
                ->formatUser($user)
                ->willReturn($userObject)
                ->shouldBeCalled();

            $this->authorizationCheckerProphecy
                ->isGranted('view', $userObject)
                ->willReturn(true)
                ->shouldBeCalled();

            $usersSent[] = $userObject;
        }
        $usersResult = $this->userService->getAll();
        $this->assertEquals($usersSent[0]->getFirstName(), $usersResult[0]->getFirstName());
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
        $region = new Region();
        $region->setLabel('region');
        $region->setcode('REG0');

        $agency = new Agency();
        $agency->setLabel('agence');
        $agency->setcode('ATG0');
        $agency->setRegion($region);

        $usersSent = [];

        $userArray = [
            'id' => 1,
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'username' => 'username',
            'email' => 'email@email.fr',
            'enabled' => true,
            'entity' => 'APPI',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'agency' => ['id' => 1],
            'region' => ['id' => 1],
            'territorialContext' => 'age',
        ];

        $userObject = $this->formatUser($userArray);

        $repositoryProphecy = $this->prophet->prophesize(UserRepository::class);
        $regionRepositoryProphecy = $this->prophet->prophesize(RegionRepository::class);
        $agencyRepositoryProphecy = $this->prophet->prophesize(AgencyRepository::class);
        $userServiceProphecy = $this->prophet->prophesize(UserService::class);

        $this->emProphecy
            ->getRepository("UserBundle:User")
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $repositoryProphecy
            ->getUserAttributes(1)
            ->willReturn([$userArray])
            ->shouldBeCalled();


        $this->emProphecy
            ->getRepository("PortalBundle:Region")
            ->willReturn($regionRepositoryProphecy)
            ->shouldBeCalled();

        $this->emProphecy
            ->getRepository("PortalBundle:Agency")
            ->willReturn($agencyRepositoryProphecy)
            ->shouldBeCalled();

        $userServiceProphecy
            ->formatUser([$userArray][0])
            ->willReturn($userObject)
            ->shouldBeCalled();

        $this->authorizationCheckerProphecy
            ->isGranted('view', $userObject)
            ->willReturn(true)
            ->shouldBeCalled();

        $usersSent[] = $userObject;
        $usersResult = $this->userService->get(1);
        $this->assertEquals($usersSent[0]->getFirstName(), $usersResult->getFirstName());
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
        $user = new User();
        $repositoryProphecy = $this->prophet->prophesize(UserRepository::class);
        $this->emProphecy
            ->getRepository('UserBundle:User')
            ->willReturn($repositoryProphecy)
            ->shouldBeCalled();

        $repositoryProphecy
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

    /**
     * @test testGetProfile
     */
    public function testGetProfile()
    {
        $user = new User();
        $maille = $user->getTerritorialContext();
        $code_maille = null;
        $codeMaille = $user->getTerritorialCode();
        $profile = [
            'gaia' => 'RJ5340',
            'nni' => 'NNI11',
            'nom' => 'gueye',
            'prenom' => 'babacar',
            'role' => ['ROLE_USER'],
            'maille' => $maille,
            'codeMaille' => ($codeMaille === null) ? '' : $codeMaille
        ];

        $user->setUsername($profile['gaia']);
        $user->setNni($profile['nni']);
        $user->setLastName($profile['nom']);
        $user->setFirstName($profile['prenom']);
        $user->setRoles($profile['role']);
        $user->setTerritorialContext($profile['maille']);
        $user->setTerritorialCode($profile['codeMaille']);

        $this->assertEquals($profile['gaia'], $user->getUsername());
        $this->assertEquals($profile['nni'], $user->getNni());
        $this->assertEquals($profile['prenom'], $user->getFirstName());
        $this->assertEquals($profile['nom'], $user->getLastName());
        $this->assertEquals($profile['role'][0], $user->getRoles()[0]);
        $this->assertEquals($profile['maille'], $user->getTerritorialContext());
        $this->assertEquals($profile['codeMaille'], $user->getTerritorialCode());

        $this->userService->getProfile($user);

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
        $u->setPhone1($userArray['phone1']);
        $u->setPhone2($userArray['phone2']);
        $u->setNni($userArray['nni']);
        $u->setEmail($userArray['email']);
        $u->setSalt(null);
        return $u;
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
