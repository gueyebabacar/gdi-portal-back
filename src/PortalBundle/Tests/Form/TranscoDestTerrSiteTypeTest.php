<?php

namespace Tests\AppBundle\Form\Type;

use PortalBundle\Form\TranscoDestTerrSiteType;
use Symfony\Component\Form\Test\TypeTestCase;

class TestedTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
                        'test' => 'Lorem Ipsum',
                        'test2' => 'Lorem Ipsum',
        );

        $type = new TranscoDestTerrSiteType();
        $form = $this->factory->create($type);
    // submit the data to the form directly
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}