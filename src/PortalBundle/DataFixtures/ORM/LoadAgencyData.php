<?php

namespace PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortalBundle\Entity\Agency;

class LoadAgencyData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $idReferenceAgency = 0;

        for ($x = 0; $x < 5; $x++) {
            for ($i = 0; $i < 5; $i++) {
                $agency = new Agency();
                $agency->setLabel('Agence ' . $idReferenceAgency);
                $agency->setCode('ATG' . $idReferenceAgency);
                $agency->setRegion($this->getReference('region-' . $x));

                $this->addReference('agency-' . $idReferenceAgency, $agency);
                $region = $this->getReference('region-' . $x)->addAgency($agency);

                $manager->persist($agency);
                $manager->persist($region);

                $idReferenceAgency += 1;
            }
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}