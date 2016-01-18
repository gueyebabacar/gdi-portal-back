<?php
namespace TranscoBundle\Tests\Form;

use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Form\TranscoDiscoType;
use Symfony\Component\Form\Test\TypeTestCase;

class TranscoDiscoTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'codeObject' => '050',
            'natOp' => 'COU13',
            'natOpLabel' => 'label',
            'optic' => 'METZ',
        );

        $form = $this->factory->create(TranscoDiscoType::class);

        $transcoDisco = new TranscoDisco();
        $transcoDisco->setCodeObject($formData['codeObject']);
        $transcoDisco->setNatOp($formData['natOp']);
        $transcoDisco->setNatOpLabel($formData['natOpLabel']);
        $transcoDisco->setOptic($formData['optic']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData['codeObject'], $form->getData()->getCodeObject());
        $this->assertEquals($formData['natOp'], $form->getData()->getNatOp());
        $this->assertEquals($formData['natOpLabel'], $form->getData()->getNatOpLabel());
        $this->assertEquals($formData['optic'], $form->getData()->getOptic());
    }
}