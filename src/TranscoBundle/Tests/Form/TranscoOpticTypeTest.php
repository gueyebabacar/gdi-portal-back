<?php
namespace TranscoBundle\Tests\Form;

use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Entity\TranscoOptic;
use TranscoBundle\Form\TranscoOpticType;
use Symfony\Component\Form\Test\TypeTestCase;

class TranscoOpticTest extends TypeTestCase
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
            'codeTypeOptic' => '050',
            'opticLabel' => 'optic label',
            'codeNatInter' => 'code nat inter',
            'labelNatInter' => 'label nat inter',
            'segmentationCode' => 'segmentation code',
            'segmentationLabel' => 'segmentation label',
            'finalCode' => 'code final',
            'finalLabel' => 'label final',
            'shortLabel' => 'label court',
            'programmingMode' => 'mode de prog',
            'calibre' => 'calibre',
            'disco' => new TranscoDisco(),
            'gmaos' => new TranscoGmao()
        );

        $transcoOptic = new TranscoOptic();
        $form = $this->factory->create(TranscoOpticType::class, $transcoOptic);

        $transcoOptic->setCodeTypeOptic($formData['codeTypeOptic']);
        $transcoOptic->setOpticLabel($formData['opticLabel']);
        $transcoOptic->setCodeNatInter($formData['codeNatInter']);
        $transcoOptic->setLabelNatInter($formData['labelNatInter']);
        $transcoOptic->setSegmentationCode($formData['segmentationCode']);
        $transcoOptic->setSegmentationLabel($formData['segmentationLabel']);
        $transcoOptic->setFinalCode($formData['finalCode']);
        $transcoOptic->setFinalLabel($formData['finalLabel']);
        $transcoOptic->setShortLabel($formData['shortLabel']);
        $transcoOptic->setProgrammingMode($formData['programmingMode']);
        $transcoOptic->setCalibre($formData['calibre']);
        $transcoOptic->setDisco($formData['disco']);
        $transcoOptic->addGmao($formData['gmaos']);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData['codeTypeOptic'], $form->getData()->getCodeTypeOptic());
        $this->assertEquals($formData['opticLabel'], $form->getData()->getOpticLabel());
        $this->assertEquals($formData['codeNatInter'], $form->getData()->getCodeNatInter());
        $this->assertEquals($formData['labelNatInter'], $form->getData()->getLabelNatInter());
    }
}