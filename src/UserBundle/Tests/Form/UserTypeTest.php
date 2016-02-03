<?php
namespace UserBundle\Tests\Form;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends KernelTestCase
{
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
//        $formData = array(
//            'firstName' => 'babacar',
//            'lastName' => 'babacartest',
//            'phone1' => '112222555',
//            'phone2' => '1122252584',
//            'password' => 'okookpasse',
//            'entity' => 'ATG',
//            'agency' => 'agency114',
//            'role' => 'role114',
//        );

        //$factory = $this->builder->getFormFactory();
        $userType = new UserType();
        $form = $this->factory->create(UserType::class, new User());

//        $user = new User();
//        $user->setFirstName($formData['firstName']);
//        $user->setLastName($formData['lastName']);
//        $user->setPhone1($formData['phone1']);
//        $user->setPhone2($formData['phone2']);
//        $user->setPassword($formData['password']);
//        $user->setEntity($formData['entity']);
//        $user->setAgency($formData['agency']);
//        $user->setRole($formData['role']);
//
//        $form->submit($formData);
//
//        $this->assertTrue($form->isSynchronized());
//        $this->assertEquals($formData['firstName'], $form->getData()->getFirstName());
//        $this->assertEquals($formData['lastName'], $form->getData()->getLastName());
//        $this->assertEquals($formData['phone1'], $form->getData()->getPhone1());
//        $this->assertEquals($formData['phone2'], $form->getData()->getPhone2());
//        $this->assertEquals($formData['password'], $form->getData()->getPassword());
//        $this->assertEquals($formData['entity'], $form->getData()->getEntity());
    }
}