<?php

namespace TranscoBundle\Tests\Entity;

use TranscoBundle\Entity\TranscoOptic;

class TranscoOpticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testTranscoGmaoSettersGetters
     *
     * @test
     * @group transco
     */
    public function testTranscoGmaoSettersGetters()
    {
        $data = array(
            'codeNatInt' => 'codeNatInt',
            'progMod' => 'progMod',
            'shortLabel' => 'shortLabel',
            'codeTypeOptoc' => 'codeTypeOptoc',
            'finalCode' => 'finalCode',
            'labelNatInter' => 'labelNatInter',
            'calibre' => 'calibre',
            'segCode' => 'segCode',
            'segValue' => 'segValue',
            'opticLabel' => 'opticLabel',
            'finalLabel' => 'finalLabel',
            'slot' => 'slot',
            'sla' => 'sla',
        );

        $transcoOptic = new TranscoOptic();

        $transcoOptic->setCodeNatInter($data['codeNatInt']);
        $transcoOptic->setProgrammingMode($data['progMod']);
        $transcoOptic->setCalibre($data['calibre']);
        $transcoOptic->setShortLabel($data['shortLabel']);
        $transcoOptic->setCodeTypeOptic($data['codeTypeOptoc']);
        $transcoOptic->setFinalCode($data['finalCode']);
        $transcoOptic->setLabelNatInter($data['labelNatInter']);
        $transcoOptic->setSegmentationCode($data['segCode']);
        $transcoOptic->setSegmentationLabel($data['segValue']);
        $transcoOptic->setOpticLabel($data['opticLabel']);
        $transcoOptic->setFinalLabel($data['finalLabel']);
        $transcoOptic->setSlot($data['slot']);
        $transcoOptic->setSla($data['sla']);

        $this->assertEquals($data['codeNatInt'],$transcoOptic->getCodeNatInter());
        $this->assertEquals($data['progMod'],$transcoOptic->getProgrammingMode());
        $this->assertEquals($data['calibre'],$transcoOptic->getCalibre());
        $this->assertEquals($data['shortLabel'],$transcoOptic->getShortLabel());
        $this->assertEquals($data['codeTypeOptoc'],$transcoOptic->getCodeTypeOptic());
        $this->assertEquals($data['finalCode'],$transcoOptic->getFinalCode());
        $this->assertEquals($data['labelNatInter'],$transcoOptic->getLabelNatInter());
        $this->assertEquals($data['segCode'],$transcoOptic->getSegmentationCode());
        $this->assertEquals($data['segValue'],$transcoOptic->getSegmentationLabel());
        $this->assertEquals($data['opticLabel'],$transcoOptic->getOpticLabel());
        $this->assertEquals($data['finalLabel'],$transcoOptic->getFinalLabel());
        $this->assertEquals($data['slot'],$transcoOptic->getSlot());
        $this->assertEquals($data['sla'],$transcoOptic->getSla());
    }
}
