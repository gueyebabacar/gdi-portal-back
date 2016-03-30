<?php
namespace UserBundle\Tests\Form;

use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use UserBundle\Entity\User;
use UserBundle\Form\RightsUserType;

class RightsUserTypeTest extends KernelTestCase
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
        $region = new Region();
        $agency = new Agency();
        $formData = array(

            'agency' => $agency->getCode(),
            'region' => $region->getCode(),
            'roles' => ['ROLE_USER'],
        );

        /** @var Form $form */
        $form = $this->factory->create(RightsUserType::class, new User());

        $user = new User();

        $user->setRegion($formData['region']);
        $user->setAgency($formData['agency']);
        $user->setRoles($formData['roles']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($formData['agency'], $form->getData()->getAgency());
        $this->assertEquals($formData['region'], $form->getData()->getRegion());
        $this->assertEquals($formData['roles'], $form->getData()->getRoles());
    }
}