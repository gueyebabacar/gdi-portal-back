<?php

namespace PortalBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PortalBundle\Entity\Role;
use PortalBundle\Form\RoleType;
use PortalBundle\Service\RoleService;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class RoleServiceTest extends \PHPUnit_Framework_TestCase
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
     * @var  RoleService
     */
    private $roleService;

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

        $this->roleService = new RoleService($em, $formFactory);
    }

    public function testGetAll()
    {
        $role = $this->createRoleTable();

        $this->emProphecy
            ->getRepository("PortalBundle:Role")
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->findAll()
            ->willReturn($role)
            ->shouldBeCalled();

        $this->assertEquals($role, $this->roleService->getAll());
    }

    public function testCreate()
    {
        $role = new Role();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->formFactoryProphecy
            ->create(RoleType::class, $role)
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
            ->persist($role)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($role, $this->roleService->create($request));
    }

    public function testGet()
    {
        $role = new Role();

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:Role'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($role)
            ->shouldBeCalled();

        $this->assertEquals($role, $this->roleService->get(1));
    }

    public function testEdit()
    {
        $role = new Role();

        /** @var ObjectProphecy $requestProphecy */
        $requestProphecy = $this->prophet->prophesize(Request::class);

        /** @var Request $request */
        $request = $requestProphecy->reveal();

        /** @var ObjectProphecy $formProphecy */
        $formProphecy = $this->prophet->prophesize(Form::class);

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:Role'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($role)
            ->shouldBeCalled();

        $this->formFactoryProphecy
            ->create(RoleType::class, $role)
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
            ->persist($role)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->assertEquals($role, $this->roleService->edit($request, 1));
    }

    public function testDelete()
    {
        $role = new Role();

        $this->emProphecy
            ->getRepository(Argument::exact('PortalBundle:Role'))
            ->willReturn($this->repositoryProphecy)
            ->shouldBeCalled();

        $this->repositoryProphecy
            ->find(1)
            ->willReturn($role)
            ->shouldBeCalled();

        $this->emProphecy
            ->remove($role)
            ->shouldBeCalled();
        $this->emProphecy
            ->flush()
            ->shouldBeCalled();

        $this->roleService->delete(1);
    }

    private function createRoleTable()
    {
        $roleData = [];

        for ($i = 0; $i < 2; $i++) {

            $role = new Role();

            $role->setLabel('Programmateur');
            $role->setCode('PROGRAMMATEUR');
            $roleData[] = $role;
        }
        return $roleData;
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
