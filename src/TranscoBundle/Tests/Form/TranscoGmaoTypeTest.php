<?php
namespace TranscoBundle\Tests\Form;

use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Form\TranscoGmaoType;
use Symfony\Component\Form\Test\TypeTestCase;

class TranscoGmaoTypeTest extends TypeTestCase
{
    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * testSubmitValidData
     *
     * @test
     * @group transco
     */
    public function testSubmitValidData()
    {
        $formData = array(
            'workType' => '050',
            'groupGame' => 'COU13',
            'counter' => 'label',
            'optic' => 'METZ',
        );

        $form = $this->factory->create(TranscoGmaoType::class);

        $transcoGmao = new TranscoGmao();
        $transcoGmao->setWorkType($formData['workType']);
        $transcoGmao->setGroupGame($formData['groupGame']);
        $transcoGmao->setCounter($formData['counter']);
        $transcoGmao->setOptic($formData['optic']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData['workType'], $form->getData()->getWorkType());
        $this->assertEquals($formData['groupGame'], $form->getData()->getGroupGame());
        $this->assertEquals($formData['counter'], $form->getData()->getCounter());
        $this->assertEquals($formData['optic'], $form->getData()->getOptic());
    }
}

