<?php
namespace TranscoBundle\Tests\Form;

use TranscoBundle\Entity\TranscoNatureInter;
use Symfony\Component\Form\Test\TypeTestCase;
use TranscoBundle\Form\TranscoNatureInterType;

class TranscoNatureInterTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'id' => 1,
            'opticNatCode' => 'ROBI',
            'opticSkill' => 'Maintenance Robinet',
            'opticNatLabel' => 'Inspection robinet reseau',
            'pictrelNatOpCode' => 'AA',
            'pictrelNatLabel' => 'Inspection robinet reseau',
            'troncatedPictrelNatOpLabel' => 'Inspection robinet reseau',
            'counter' => 1,
        );

        $form = $this->factory->create(TranscoNatureInterType::class);

        $transcoNatureInter = new TranscoNatureInter();
        $transcoNatureInter->setCounter($formData['counter']);
        $transcoNatureInter->setOpticNatCode($formData['opticNatCode']);
        $transcoNatureInter->setOpticNatLabel($formData['opticNatLabel']);
        $transcoNatureInter->setOpticSkill($formData['opticSkill']);
        $transcoNatureInter->setPictrelNatOpCode($formData['pictrelNatOpCode']);
        $transcoNatureInter->setPictrelNatOpLabel($formData['pictrelNatLabel']);
        $transcoNatureInter->setTroncatedPictrelNatOpLabel($formData['troncatedPictrelNatOpLabel']);
        // submit the data to the form directly


        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($formData['opticNatCode'], $form->getData()->getOpticNatCode());
    }
}