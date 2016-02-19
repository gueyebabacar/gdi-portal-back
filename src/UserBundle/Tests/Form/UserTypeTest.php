<?php
namespace UserBundle\Tests\Form;

use PortalBundle\Entity\Agency;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;
use UserBundle\Form\UserType;

class UserTypeTest extends KernelTestCase
{
    /**
     * @var FormFactory
     */
    protected $factory;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        self::bootKernel();
        $container = self::$kernel->getContainer();
        $this->factory = $container->get("form.factory");
    }

    /**
     * testSubmitValidData
     *
     * @test
     * @group portal
     */
    public function testSubmitValidData()
    {
        $formData = array(
            'firstName' => 'babacar',
            'lastName' => 'babacartest',
            'phone1' => '112222555',
            'phone2' => '1122252584',
            'password' => 'okookpasse',
            'entity' => 'ATG',
            'agency' => new Agency(),
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
        );

        /** @var Form $form */
        $form = $this->factory->create(UserType::class, new User());

        $user = new User();
        $user->setFirstName($formData['firstName']);
        $user->setLastName($formData['lastName']);
        $user->setPhone1($formData['phone1']);
        $user->setPhone2($formData['phone2']);
        $user->setPassword($formData['password']);
        $user->setEntity($formData['entity']);
        $user->setAgency($formData['agency']);
        $user->setRoles($formData['roles']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData['firstName'], $form->getData()->getFirstName());
        $this->assertEquals($formData['lastName'], $form->getData()->getLastName());
        $this->assertEquals($formData['phone1'], $form->getData()->getPhone1());
        $this->assertEquals($formData['phone2'], $form->getData()->getPhone2());
        $this->assertEquals($formData['password'], $form->getData()->getPassword());
        $this->assertEquals($formData['entity'], $form->getData()->getEntity());
    }
}