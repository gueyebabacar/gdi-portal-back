<?php

namespace TranscoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TranscoBundle\Entity\TranscoAgence;

class LoadTranscoAgenceData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $transcoAgence = new TranscoAgence();

            $transcoAgence->setAgenceLabel('AgenceLabel-'.$i);
            $transcoAgence->setCenter('Centre-'.$i);
            $transcoAgence->setCodeAgence('CodeAgence-'.$i);
            $transcoAgence->setDestinataire('Destinataire-'.$i);
            $transcoAgence->setInseeCode('INSEE-'.$i);
            $transcoAgence->setPr('ATG-'.$i);
            $manager->persist($transcoAgence);
        }

        $manager->flush();
    }
}