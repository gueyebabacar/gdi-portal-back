<?php
namespace TranscoBundle\Tests\Form;

use TranscoBundle\Entity\TranscoDestTerrSite;
use TranscoBundle\Form\TranscoDestTerrSiteType;
use Symfony\Component\Form\Test\TypeTestCase;

class TranscoDestTerrSiteTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'territory' => '050',
            'adressee' => 'COU13',
            'site' => 'METZ',
            'pr' => 'X',
            'idRefStructureOp' => 'ATG050',
        );

        $form = $this->factory->create(TranscoDestTerrSiteType::class);

        $transcoDestTerrSite = new TranscoDestTerrSite();
        $transcoDestTerrSite->setTerritory($formData['territory']);
        $transcoDestTerrSite->setAdressee($formData['adressee']);
        $transcoDestTerrSite->setSite($formData['site']);
        $transcoDestTerrSite->setPr($formData['pr']);
        $transcoDestTerrSite->setIdRefStructureOp($formData['idRefStructureOp']);
        // submit the data to the form directly


        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $view = $form->createView();

        $this->assertEquals($formData['territory'], $form->getData()->getTerritory());
    }
}