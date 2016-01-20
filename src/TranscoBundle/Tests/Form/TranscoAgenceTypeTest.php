<?php
namespace TranscoBundle\Tests\Form;

use TranscoBundle\Entity\TranscoAgence;
use TranscoBundle\Form\TranscoAgenceType;
use Symfony\Component\Form\Test\TypeTestCase;

class TranscoAgenceTypeTest extends TypeTestCase
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
            'inseeCode' => '050',
            'codeAgence' => 'COU13',
            'agenceLabel' => 'label',
            'center' => 'METZ',
            'destinataire' => 'destinataire',
            'pr' => 'ATG050',
        );

        $form = $this->factory->create(TranscoAgenceType::class);

        $transcoAgence = new TranscoAgence();
        $transcoAgence->setInseeCode($formData['inseeCode']);
        $transcoAgence->setCodeAgence($formData['codeAgence']);
        $transcoAgence->setAgenceLabel($formData['agenceLabel']);
        $transcoAgence->setCenter($formData['center']);
        $transcoAgence->setDestinataire($formData['destinataire']);
        $transcoAgence->setPr($formData['pr']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData['inseeCode'], $form->getData()->getInseeCode());
        $this->assertEquals($formData['codeAgence'], $form->getData()->getCodeAgence());
        $this->assertEquals($formData['agenceLabel'], $form->getData()->getAgenceLabel());
        $this->assertEquals($formData['center'], $form->getData()->getCenter());
        $this->assertEquals($formData['destinataire'], $form->getData()->getDestinataire());
        $this->assertEquals($formData['pr'], $form->getData()->getPr());
    }
}