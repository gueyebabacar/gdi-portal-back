<?php
namespace TranscoBundle\Tests\Form;

use TranscoBundle\Entity\TranscoNatureOpe;
use Symfony\Component\Form\Test\TypeTestCase;
use TranscoBundle\Form\TranscoNatureOpeType;

class TranscoNatureOpeTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'workType' => 'ROBI',
            'gammeGroup' => 'gammeGroup',
            'purpose' => 'purpose',
            'counter' => 1,
            'segmentationValue' => 'segmentationValue',
            'segmentationName' => 'segmentationName',
            'programmingMode' => 'programmingMode',
            'natureInterCode' => 'natureInterCode',
        );

        $form = $this->factory->create(TranscoNatureOpeType::class);

        $transcoNatureOpe = new TranscoNatureOpe();

        $transcoNatureOpe->setWorkType($formData['workType']);
        $transcoNatureOpe->setGammeGroup($formData['gammeGroup']);
        $transcoNatureOpe->setPurpose($formData['purpose']);
        $transcoNatureOpe->setCounter($formData['counter']);
        $transcoNatureOpe->setSegmentationValue($formData['segmentationValue']);
        $transcoNatureOpe->setSegmentationName($formData['segmentationName']);
        $transcoNatureOpe->setProgrammingMode($formData['programmingMode']);
        $transcoNatureOpe->setNatureInterCode($formData['natureInterCode']);
        // submit the data to the form directly


        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($formData['gammeGroup'], $form->getData()->getGammeGroup());
    }
}